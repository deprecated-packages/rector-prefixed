<?php

declare (strict_types=1);
namespace Rector\Php74\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\UnionType as PhpParserUnionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\DeadDocBlock\TagRemover\VarTagRemover;
use Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;
use Rector\VendorLocker\VendorLockResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @source https://wiki.php.net/rfc/typed_properties_v2#proposal
 *
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\TypedPropertyRectorTest
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\ClassLikeTypesOnlyTest
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\DoctrineTypedPropertyRectorTest
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\ImportedTest
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\UnionTypedPropertyRectorTest
 */
final class TypedPropertyRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_LIKE_TYPE_ONLY = 'class_like_type_only';
    /**
     * Useful for refactoring of huge applications. Taking types first narrows scope
     * @var bool
     */
    private $classLikeTypeOnly = \false;
    /**
     * @var PropertyTypeInferer
     */
    private $propertyTypeInferer;
    /**
     * @var VendorLockResolver
     */
    private $vendorLockResolver;
    /**
     * @var DoctrineTypeAnalyzer
     */
    private $doctrineTypeAnalyzer;
    /**
     * @var VarTagRemover
     */
    private $varTagRemover;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer $propertyTypeInferer, \Rector\VendorLocker\VendorLockResolver $vendorLockResolver, \Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer, \Rector\DeadDocBlock\TagRemover\VarTagRemover $varTagRemover)
    {
        $this->propertyTypeInferer = $propertyTypeInferer;
        $this->vendorLockResolver = $vendorLockResolver;
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
        $this->varTagRemover = $varTagRemover;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes property `@var` annotations from annotation to type.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    /**
     * @var int
     */
    private count;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    private int count;
}
CODE_SAMPLE
, [self::CLASS_LIKE_TYPE_ONLY => \false])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            return null;
        }
        // type is already set → skip
        if ($node->type !== null) {
            return null;
        }
        // skip multiple properties
        if (\count($node->props) > 1) {
            return null;
        }
        $varType = $this->propertyTypeInferer->inferProperty($node);
        if ($varType instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        $propertyTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($varType, \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper::KIND_PROPERTY);
        if ($propertyTypeNode === null) {
            return null;
        }
        // is not class-type and should be skipped
        if ($this->shouldSkipNonClassLikeType($propertyTypeNode)) {
            return null;
        }
        // false positive
        if ($propertyTypeNode instanceof \PhpParser\Node\Name && $this->isName($propertyTypeNode, 'mixed')) {
            return null;
        }
        if ($this->vendorLockResolver->isPropertyTypeChangeVendorLockedIn($node)) {
            return null;
        }
        $this->varTagRemover->removeVarPhpTagValueNodeIfNotComment($node, $varType);
        $this->removeDefaultValueForDoctrineCollection($node, $varType);
        $this->addDefaultValueNullForNullableType($node, $varType);
        $node->type = $propertyTypeNode;
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->classLikeTypeOnly = $configuration[self::CLASS_LIKE_TYPE_ONLY] ?? \false;
    }
    /**
     * @param Name|NullableType|PhpParserUnionType $node
     */
    private function shouldSkipNonClassLikeType(\PhpParser\Node $node) : bool
    {
        // unwrap nullable type
        if ($node instanceof \PhpParser\Node\NullableType) {
            $node = $node->type;
        }
        $typeName = $this->getName($node);
        if ($typeName === 'null') {
            return \true;
        }
        if ($typeName === null) {
            return \false;
        }
        if ($typeName === 'callable') {
            return \true;
        }
        if (!$this->classLikeTypeOnly) {
            return \false;
        }
        return !\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($typeName);
    }
    private function removeDefaultValueForDoctrineCollection(\PhpParser\Node\Stmt\Property $property, \PHPStan\Type\Type $propertyType) : void
    {
        if (!$this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($propertyType)) {
            return;
        }
        $onlyProperty = $property->props[0];
        $onlyProperty->default = null;
    }
    private function addDefaultValueNullForNullableType(\PhpParser\Node\Stmt\Property $property, \PHPStan\Type\Type $propertyType) : void
    {
        if (!$propertyType instanceof \PHPStan\Type\UnionType) {
            return;
        }
        if (!$propertyType->isSuperTypeOf(new \PHPStan\Type\NullType())->yes()) {
            return;
        }
        $onlyProperty = $property->props[0];
        // skip is already has value
        if ($onlyProperty->default !== null) {
            return;
        }
        $onlyProperty->default = $this->nodeFactory->createNull();
    }
}
