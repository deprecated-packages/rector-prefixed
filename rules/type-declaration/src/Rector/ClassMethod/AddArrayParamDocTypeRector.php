<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayParamDocTypeRector\AddArrayParamDocTypeRectorTest
 */
final class AddArrayParamDocTypeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ParamTypeInferer
     */
    private $paramTypeInferer;
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer $paramTypeInferer, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger)
    {
        $this->paramTypeInferer = $paramTypeInferer;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds @param annotation to array parameters inferred from the rest of the code', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var int[]
     */
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var int[]
     */
    private $values;

    /**
     * @param int[] $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->getParams() === []) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        foreach ($node->getParams() as $param) {
            if ($this->shouldSkipParam($param)) {
                continue;
            }
            $type = $this->paramTypeInferer->inferParam($param);
            if ($type instanceof \PHPStan\Type\MixedType) {
                continue;
            }
            $paramName = $this->getName($param);
            $this->phpDocTypeChanger->changeParamType($phpDocInfo, $type, $param, $paramName);
        }
        if ($phpDocInfo->hasChanged()) {
            return $node;
        }
        return null;
    }
    private function shouldSkipParam(\PhpParser\Node\Param $param) : bool
    {
        // type missing at all
        if ($param->type === null) {
            return \true;
        }
        // not an array type
        if (!$this->isName($param->type, 'array')) {
            return \true;
        }
        // not an array type
        $paramStaticType = $this->getStaticType($param);
        if ($paramStaticType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        if (!$paramStaticType instanceof \PHPStan\Type\ArrayType) {
            return \true;
        }
        if (!$paramStaticType->getIterableValueType() instanceof \PHPStan\Type\MixedType) {
            return \true;
        }
        // is defined mixed[] explicitly
        /** @var MixedType $mixedType */
        $mixedType = $paramStaticType->getIterableValueType();
        return $mixedType->isExplicitMixed();
    }
}
