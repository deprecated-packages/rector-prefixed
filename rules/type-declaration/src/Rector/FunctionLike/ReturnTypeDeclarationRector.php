<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\UnionType as PhpParserUnionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\Core\ValueObject\MethodName;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use Rector\TypeDeclaration\ChildPopulator\ChildReturnPopulator;
use Rector\TypeDeclaration\PhpDocParser\NonInformativeReturnTagRemover;
use Rector\TypeDeclaration\TypeAlreadyAddedChecker\ReturnTypeAlreadyAddedChecker;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer;
use Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnTypeOverrideGuard;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector\ReturnTypeDeclarationRectorTest
 */
final class ReturnTypeDeclarationRector extends \Rector\TypeDeclaration\Rector\FunctionLike\AbstractTypeDeclarationRector
{
    /**
     * @var string[]
     */
    private const EXCLUDED_METHOD_NAMES = [\Rector\Core\ValueObject\MethodName::CONSTRUCT, \Rector\Core\ValueObject\MethodName::DESCTRUCT, \Rector\Core\ValueObject\MethodName::CLONE];
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
    public function __construct(\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \Rector\TypeDeclaration\ChildPopulator\ChildReturnPopulator $childReturnPopulator, \Rector\TypeDeclaration\TypeAlreadyAddedChecker\ReturnTypeAlreadyAddedChecker $returnTypeAlreadyAddedChecker, \Rector\TypeDeclaration\PhpDocParser\NonInformativeReturnTagRemover $nonInformativeReturnTagRemover, \Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnTypeOverrideGuard $classMethodReturnTypeOverrideGuard, bool $overrideExistingReturnTypes = \true)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->overrideExistingReturnTypes = $overrideExistingReturnTypes;
        $this->returnTypeAlreadyAddedChecker = $returnTypeAlreadyAddedChecker;
        $this->nonInformativeReturnTagRemover = $nonInformativeReturnTagRemover;
        $this->childReturnPopulator = $childReturnPopulator;
        $this->classMethodReturnTypeOverrideGuard = $classMethodReturnTypeOverrideGuard;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change @return types and type from static analysis to type declarations if not a BC-break', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod && $this->shouldSkip($node)) {
            return null;
        }
        $inferedType = $this->returnTypeInferer->inferFunctionLikeWithExcludedInferers($node, [\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer::class]);
        if ($inferedType instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        if ($this->returnTypeAlreadyAddedChecker->isSameOrBetterReturnTypeAlreadyAdded($node, $inferedType)) {
            return null;
        }
        return $this->processType($node, $inferedType);
    }
    /**
     * @param ClassMethod|Function_ $node
     */
    private function processType(\PhpParser\Node $node, \PHPStan\Type\Type $inferedType) : ?\PhpParser\Node
    {
        $inferredReturnNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($inferedType, \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper::KIND_RETURN);
        // nothing to change in PHP code
        if ($inferredReturnNode === null) {
            return null;
        }
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
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->childReturnPopulator->populateChildren($node, $inferedType);
        }
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return \true;
        }
        if ($this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        if (!$this->overrideExistingReturnTypes && $classMethod->returnType !== null) {
            return \true;
        }
        if ($this->isNames($classMethod, self::EXCLUDED_METHOD_NAMES)) {
            return \true;
        }
        return $this->vendorLockResolver->isReturnChangeVendorLockedIn($classMethod);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function shouldSkipInferredReturnNode(\PhpParser\Node\FunctionLike $functionLike, \PhpParser\Node $inferredReturnNode) : bool
    {
        // already overridden by previous populateChild() method run
        if ($functionLike->returnType === null) {
            return \false;
        }
        return (bool) $functionLike->returnType->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::DO_NOT_CHANGE);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function shouldSkipExistingReturnType(\PhpParser\Node\FunctionLike $functionLike, \PHPStan\Type\Type $inferedType) : bool
    {
        if ($functionLike->returnType === null) {
            return \false;
        }
        $currentType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionLike->returnType);
        if ($functionLike instanceof \PhpParser\Node\Stmt\ClassMethod && $this->vendorLockResolver->isReturnChangeVendorLockedIn($functionLike)) {
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
    private function addReturnType(\PhpParser\Node\FunctionLike $functionLike, \PhpParser\Node $inferredReturnNode) : void
    {
        if ($functionLike->returnType === null) {
            $functionLike->returnType = $inferredReturnNode;
            return;
        }
        $isSubtype = $this->phpParserTypeAnalyzer->isSubtypeOf($inferredReturnNode, $functionLike->returnType);
        if ($this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::COVARIANT_RETURN) && $isSubtype) {
            $functionLike->returnType = $inferredReturnNode;
            return;
        }
        if (!$isSubtype) {
            // type override with correct one
            $functionLike->returnType = $inferredReturnNode;
            return;
        }
    }
    /**
     * E.g. current E, new type A, E extends A → true
     */
    private function isCurrentObjectTypeSubType(\PHPStan\Type\Type $currentType, \PHPStan\Type\Type $inferedType) : bool
    {
        if (!$currentType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        if (!$inferedType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        return \is_a($currentType->getClassName(), $inferedType->getClassName(), \true);
    }
    private function isNullableTypeSubType(\PHPStan\Type\Type $currentType, \PHPStan\Type\Type $inferedType) : bool
    {
        if (!$currentType instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
        if (!$inferedType instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
        return $inferedType->isSubTypeOf($currentType)->yes();
    }
}
