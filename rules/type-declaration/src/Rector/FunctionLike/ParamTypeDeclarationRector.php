<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\FunctionLike;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ChildPopulator\ChildParamPopulator;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\NewType;
use ReflectionClass;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\FunctionLike\ParamTypeDeclarationRector\ParamTypeDeclarationRectorTest
 */
final class ParamTypeDeclarationRector extends \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\FunctionLike\AbstractTypeDeclarationRector
{
    /**
     * @var ParamTypeInferer
     */
    private $paramTypeInferer;
    /**
     * @var ChildParamPopulator
     */
    private $childParamPopulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ChildPopulator\ChildParamPopulator $childParamPopulator, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer $paramTypeInferer)
    {
        $this->paramTypeInferer = $paramTypeInferer;
        $this->childParamPopulator = $childParamPopulator;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change @param types to type declarations if not a BC-break', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return null;
        }
        if ($node->params === null) {
            return null;
        }
        if ($node->params === []) {
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
    private function refactorParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, int $position) : void
    {
        if ($this->shouldSkipParam($param, $functionLike, $position)) {
            return;
        }
        $inferedType = $this->paramTypeInferer->inferParam($param);
        if ($inferedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return;
        }
        if ($this->isTraitType($inferedType)) {
            return;
        }
        $paramTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($inferedType, \_PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper::KIND_PARAM);
        if ($paramTypeNode === null) {
            return;
        }
        $param->type = $paramTypeNode;
        $this->childParamPopulator->populateChildClassMethod($functionLike, $position, $inferedType);
    }
    private function shouldSkipParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, int $position) : bool
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
        return !$param->type->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\NewType::HAS_NEW_INHERITED_TYPE, \false);
    }
    private function isTraitType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $fullyQualifiedName = $this->getFullyQualifiedName($type);
        $reflectionClass = new \ReflectionClass($fullyQualifiedName);
        return $reflectionClass->isTrait();
    }
    private function getFullyQualifiedName(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
}
