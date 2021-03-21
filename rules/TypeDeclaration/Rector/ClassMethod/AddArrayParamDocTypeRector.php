<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\PhpDoc\TagRemover\ParamTagRemover;
use Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector\AddArrayParamDocTypeRectorTest
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
    /**
     * @var ParamTagRemover
     */
    private $paramTagRemover;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer $paramTypeInferer, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger, \Rector\DeadCode\PhpDoc\TagRemover\ParamTagRemover $paramTagRemover)
    {
        $this->paramTypeInferer = $paramTypeInferer;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
        $this->paramTagRemover = $paramTagRemover;
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
     * @return array<class-string<Node>>
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
            $paramType = $this->paramTypeInferer->inferParam($param);
            if ($paramType instanceof \PHPStan\Type\MixedType) {
                continue;
            }
            $paramName = $this->getName($param);
            $this->phpDocTypeChanger->changeParamType($phpDocInfo, $paramType, $param, $paramName);
        }
        if ($phpDocInfo->hasChanged()) {
            $this->paramTagRemover->removeParamTagsIfUseless($phpDocInfo, $node);
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
        $paramType = $this->nodeTypeResolver->resolve($param->type);
        // weird case for maybe interface
        if ($paramType->isIterable()->maybe() && $paramType instanceof \PHPStan\Type\ObjectType) {
            return \true;
        }
        $isArrayable = $paramType->isIterable()->yes() || $paramType->isArray()->yes() || ($paramType->isIterable()->maybe() || $paramType->isArray()->maybe());
        if (!$isArrayable) {
            return \true;
        }
        return $this->isArrayExplicitMixed($paramType);
    }
    private function isArrayExplicitMixed(\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        $iterableValueType = $type->getIterableValueType();
        if (!$iterableValueType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        return $iterableValueType->isExplicitMixed();
    }
}
