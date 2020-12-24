<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\FunctionLike;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ChildPopulator\ChildReturnPopulator;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\PhpDocParser\NonInformativeReturnTagRemover;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeAlreadyAddedChecker\ReturnTypeAlreadyAddedChecker;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector\ReturnTypeDeclarationRectorTest
 */
final class ReturnTypeDeclarationRector extends \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\FunctionLike\AbstractTypeDeclarationRector
{
    /**
     * @var string[]
     */
    private const EXCLUDED_METHOD_NAMES = [\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT, \_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::DESCTRUCT, '__clone'];
    /**
     * @var bool
     */
    private $overrideExistingReturnTypes = \true;
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    /**
     * @var ReturnTypeAlreadyAddedChecker
     */
    private $returnTypeAlreadyAddedChecker;
    /**
     * @var NonInformativeReturnTagRemover
     */
    private $nonInformativeReturnTagRemover;
    /**
     * @var ChildReturnPopulator
     */
    private $childReturnPopulator;
    /**
     * @var ClassMethodReturnTypeOverrideGuard
     */
    private $classMethodReturnTypeOverrideGuard;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ChildPopulator\ChildReturnPopulator $childReturnPopulator, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeAlreadyAddedChecker\ReturnTypeAlreadyAddedChecker $returnTypeAlreadyAddedChecker, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\PhpDocParser\NonInformativeReturnTagRemover $nonInformativeReturnTagRemover, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard $classMethodReturnTypeOverrideGuard, bool $overrideExistingReturnTypes = \true)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->overrideExistingReturnTypes = $overrideExistingReturnTypes;
        $this->returnTypeAlreadyAddedChecker = $returnTypeAlreadyAddedChecker;
        $this->nonInformativeReturnTagRemover = $nonInformativeReturnTagRemover;
        $this->childReturnPopulator = $childReturnPopulator;
        $this->classMethodReturnTypeOverrideGuard = $classMethodReturnTypeOverrideGuard;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change @return types and type from static analysis to type declarations if not a BC-break', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @return int
     */
    public function getCount()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function getCount(): int
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        $inferedType = $this->returnTypeInferer->inferFunctionLikeWithExcludedInferers($node, [\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer::class]);
        if ($inferedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return null;
        }
        if ($this->returnTypeAlreadyAddedChecker->isSameOrBetterReturnTypeAlreadyAdded($node, $inferedType)) {
            return null;
        }
        $inferredReturnNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($inferedType, \_PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper::KIND_RETURN);
        if ($this->shouldSkipInferredReturnNode($node, $inferredReturnNode)) {
            return null;
        }
        // should be previous overridden?
        if ($node->returnType !== null && $this->shouldSkipExistingReturnType($node, $inferedType)) {
            return null;
        }
        /** @var Name|NullableType|PhpParserUnionType $inferredReturnNode */
        $this->addReturnType($node, $inferredReturnNode);
        $this->nonInformativeReturnTagRemover->removeReturnTagIfNotUseful($node);
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
            $this->childReturnPopulator->populateChildren($node, $inferedType);
        }
        return $node;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function shouldSkip(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return \true;
        }
        if (!$this->overrideExistingReturnTypes && $functionLike->returnType !== null) {
            return \true;
        }
        if (!$functionLike instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        if ($this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethod($functionLike)) {
            return \true;
        }
        return $this->isNames($functionLike, self::EXCLUDED_METHOD_NAMES);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function shouldSkipInferredReturnNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $inferredReturnNode) : bool
    {
        // nothing to change in PHP code
        if ($inferredReturnNode === null) {
            return \true;
        }
        // already overridden by previous populateChild() method run
        if ($functionLike->returnType === null) {
            return \false;
        }
        return (bool) $functionLike->returnType->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::DO_NOT_CHANGE);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function shouldSkipExistingReturnType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $inferedType) : bool
    {
        if ($functionLike->returnType === null) {
            return \false;
        }
        $currentType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        if ($functionLike instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod && $this->vendorLockResolver->isReturnChangeVendorLockedIn($functionLike)) {
            return \true;
        }
        if ($this->isCurrentObjectTypeSubType($currentType, $inferedType)) {
            return \true;
        }
        return $this->isNullableTypeSubType($currentType, $inferedType);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     * @param Name|NullableType|PhpParserUnionType $inferredReturnNode
     */
    private function addReturnType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $inferredReturnNode) : void
    {
        if ($functionLike->returnType !== null) {
            $isSubtype = $this->phpParserTypeAnalyzer->isSubtypeOf($inferredReturnNode, $functionLike->returnType);
            if ($this->isAtLeastPhpVersion(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature::COVARIANT_RETURN) && $isSubtype) {
                $functionLike->returnType = $inferredReturnNode;
            } elseif (!$isSubtype) {
                // type override with correct one
                $functionLike->returnType = $inferredReturnNode;
            }
        } else {
            $functionLike->returnType = $inferredReturnNode;
        }
    }
    /**
     * E.g. current E, new type A, E extends A → true
     */
    private function isCurrentObjectTypeSubType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $currentType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $inferedType) : bool
    {
        if (!$currentType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
            return \false;
        }
        if (!$inferedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
            return \false;
        }
        return \is_a($currentType->getClassName(), $inferedType->getClassName(), \true);
    }
    private function isNullableTypeSubType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $currentType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $inferedType) : bool
    {
        if (!$currentType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            return \false;
        }
        if (!$inferedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            return \false;
        }
        return $inferedType->isSubTypeOf($currentType)->yes();
    }
}
