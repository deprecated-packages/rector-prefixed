<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\FunctionLike;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ChildPopulator\ChildReturnPopulator;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\PhpDocParser\NonInformativeReturnTagRemover;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeAlreadyAddedChecker\ReturnTypeAlreadyAddedChecker;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector\ReturnTypeDeclarationRectorTest
 */
final class ReturnTypeDeclarationRector extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\FunctionLike\AbstractTypeDeclarationRector
{
    /**
     * @var string[]
     */
    private const EXCLUDED_METHOD_NAMES = [\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT, \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::DESCTRUCT, '__clone'];
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ChildPopulator\ChildReturnPopulator $childReturnPopulator, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeAlreadyAddedChecker\ReturnTypeAlreadyAddedChecker $returnTypeAlreadyAddedChecker, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\PhpDocParser\NonInformativeReturnTagRemover $nonInformativeReturnTagRemover, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard $classMethodReturnTypeOverrideGuard, bool $overrideExistingReturnTypes = \true)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->overrideExistingReturnTypes = $overrideExistingReturnTypes;
        $this->returnTypeAlreadyAddedChecker = $returnTypeAlreadyAddedChecker;
        $this->nonInformativeReturnTagRemover = $nonInformativeReturnTagRemover;
        $this->childReturnPopulator = $childReturnPopulator;
        $this->classMethodReturnTypeOverrideGuard = $classMethodReturnTypeOverrideGuard;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change @return types and type from static analysis to type declarations if not a BC-break', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $inferedType = $this->returnTypeInferer->inferFunctionLikeWithExcludedInferers($node, [\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer::class]);
        if ($inferedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return null;
        }
        if ($this->returnTypeAlreadyAddedChecker->isSameOrBetterReturnTypeAlreadyAdded($node, $inferedType)) {
            return null;
        }
        $inferredReturnNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($inferedType, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper::KIND_RETURN);
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
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            $this->childReturnPopulator->populateChildren($node, $inferedType);
        }
        return $node;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return \true;
        }
        if (!$this->overrideExistingReturnTypes && $functionLike->returnType !== null) {
            return \true;
        }
        if (!$functionLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
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
    private function shouldSkipInferredReturnNode(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, ?\_PhpScoperb75b35f52b74\PhpParser\Node $inferredReturnNode) : bool
    {
        // nothing to change in PHP code
        if ($inferredReturnNode === null) {
            return \true;
        }
        // already overridden by previous populateChild() method run
        if ($functionLike->returnType === null) {
            return \false;
        }
        return (bool) $functionLike->returnType->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::DO_NOT_CHANGE);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function shouldSkipExistingReturnType(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $inferedType) : bool
    {
        if ($functionLike->returnType === null) {
            return \false;
        }
        $currentType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        if ($functionLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod && $this->vendorLockResolver->isReturnChangeVendorLockedIn($functionLike)) {
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
    private function addReturnType(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, \_PhpScoperb75b35f52b74\PhpParser\Node $inferredReturnNode) : void
    {
        if ($functionLike->returnType !== null) {
            $isSubtype = $this->phpParserTypeAnalyzer->isSubtypeOf($inferredReturnNode, $functionLike->returnType);
            if ($this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::COVARIANT_RETURN) && $isSubtype) {
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
    private function isCurrentObjectTypeSubType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $currentType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $inferedType) : bool
    {
        if (!$currentType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \false;
        }
        if (!$inferedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \false;
        }
        return \is_a($currentType->getClassName(), $inferedType->getClassName(), \true);
    }
    private function isNullableTypeSubType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $currentType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $inferedType) : bool
    {
        if (!$currentType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return \false;
        }
        if (!$inferedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return \false;
        }
        return $inferedType->isSubTypeOf($currentType)->yes();
    }
}
