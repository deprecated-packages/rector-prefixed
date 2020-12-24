<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\FunctionLike;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ChildPopulator\ChildParamPopulator;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\NewType;
use ReflectionClass;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\FunctionLike\ParamTypeDeclarationRector\ParamTypeDeclarationRectorTest
 */
final class ParamTypeDeclarationRector extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\FunctionLike\AbstractTypeDeclarationRector
{
    /**
     * @var ParamTypeInferer
     */
    private $paramTypeInferer;
    /**
     * @var ChildParamPopulator
     */
    private $childParamPopulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ChildPopulator\ChildParamPopulator $childParamPopulator, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer $paramTypeInferer)
    {
        $this->paramTypeInferer = $paramTypeInferer;
        $this->childParamPopulator = $childParamPopulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change @param types to type declarations if not a BC-break', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class ParentClass
{
    /**
     * @param int $number
     */
    public function keep($number)
    {
    }
}

final class ChildClass extends ParentClass
{
    /**
     * @param int $number
     */
    public function keep($number)
    {
    }

    /**
     * @param int $number
     */
    public function change($number)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class ParentClass
{
    /**
     * @param int $number
     */
    public function keep($number)
    {
    }
}

final class ChildClass extends ParentClass
{
    /**
     * @param int $number
     */
    public function keep($number)
    {
    }

    /**
     * @param int $number
     */
    public function change(int $number)
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return null;
        }
        if ($node->params === null || $node->params === []) {
            return null;
        }
        foreach ($node->params as $position => $param) {
            $this->refactorParam($param, $node, (int) $position);
        }
        return null;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function refactorParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, int $position) : void
    {
        if ($this->shouldSkipParam($param, $functionLike, $position)) {
            return;
        }
        $inferedType = $this->paramTypeInferer->inferParam($param);
        if ($inferedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return;
        }
        if ($this->isTraitType($inferedType)) {
            return;
        }
        $paramTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($inferedType, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper::KIND_PARAM);
        if ($paramTypeNode === null) {
            return;
        }
        $param->type = $paramTypeNode;
        $this->childParamPopulator->populateChildClassMethod($functionLike, $position, $inferedType);
    }
    private function shouldSkipParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, int $position) : bool
    {
        if ($this->vendorLockResolver->isClassMethodParamLockedIn($functionLike, $position)) {
            return \true;
        }
        if ($param->variadic) {
            return \true;
        }
        // no type → check it
        if ($param->type === null) {
            return \false;
        }
        // already set → skip
        return !$param->type->getAttribute(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\NewType::HAS_NEW_INHERITED_TYPE, \false);
    }
    private function isTraitType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $fullyQualifiedName = $this->getFullyQualifiedName($type);
        $reflectionClass = new \ReflectionClass($fullyQualifiedName);
        return $reflectionClass->isTrait();
    }
    private function getFullyQualifiedName(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
}
