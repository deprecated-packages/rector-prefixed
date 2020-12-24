<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Rector\Property;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;
use _PhpScopere8e811afab72\Rector\VendorLocker\VendorLockResolver;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @source https://wiki.php.net/rfc/typed_properties_v2#proposal
 *
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\TypedPropertyRectorTest
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\ClassLikeTypesOnlyTest
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\DoctrineTypedPropertyRectorTest
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\ImportedTest
 * @see \Rector\Php74\Tests\Rector\Property\TypedPropertyRector\UnionTypedPropertyRectorTest
 */
final class TypedPropertyRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_LIKE_TYPE_ONLY = '$classLikeTypeOnly';
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
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer $propertyTypeInferer, \_PhpScopere8e811afab72\Rector\VendorLocker\VendorLockResolver $vendorLockResolver, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer)
    {
        $this->propertyTypeInferer = $propertyTypeInferer;
        $this->vendorLockResolver = $vendorLockResolver;
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes property `@var` annotations from annotation to type.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            return null;
        }
        // type is already set → skip
        if ($node->type !== null) {
            return null;
        }
        $varType = $this->propertyTypeInferer->inferProperty($node);
        if ($varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return null;
        }
        $propertyTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($varType, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper::KIND_PROPERTY);
        if ($propertyTypeNode === null) {
            return null;
        }
        // is not class-type and should be skipped
        if ($this->shouldSkipNonClassLikeType($propertyTypeNode)) {
            return null;
        }
        // false positive
        if ($propertyTypeNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name && $this->isName($propertyTypeNode, 'mixed')) {
            return null;
        }
        if ($this->vendorLockResolver->isPropertyTypeChangeVendorLockedIn($node)) {
            return null;
        }
        $this->removeVarPhpTagValueNodeIfNotComment($node, $varType);
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
    private function shouldSkipNonClassLikeType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        // unwrap nullable type
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            $node = $node->type;
        }
        $typeName = $this->getName($node);
        if ($typeName === null) {
            return \false;
        }
        if ($typeName === 'callable') {
            return \true;
        }
        if (!$this->classLikeTypeOnly) {
            return \false;
        }
        return !\_PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($typeName);
    }
    private function removeVarPhpTagValueNodeIfNotComment(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : void
    {
        // keep doctrine collection narrow type
        if ($this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($type)) {
            return;
        }
        $propertyPhpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        // nothing to remove
        if ($propertyPhpDocInfo === null) {
            return;
        }
        $varTagValueNode = $propertyPhpDocInfo->getByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
        if ($varTagValueNode === null) {
            return;
        }
        // has description? keep it
        if ($varTagValueNode->description !== '') {
            return;
        }
        // keep generic types
        if ($varTagValueNode->type instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            return;
        }
        // keep string[] etc.
        if ($this->isNonBasicArrayType($property, $varTagValueNode)) {
            return;
        }
        $propertyPhpDocInfo->removeByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
    }
    private function removeDefaultValueForDoctrineCollection(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\PHPStan\Type\Type $propertyType) : void
    {
        if (!$this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($propertyType)) {
            return;
        }
        $onlyProperty = $property->props[0];
        $onlyProperty->default = null;
    }
    private function addDefaultValueNullForNullableType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\PHPStan\Type\Type $propertyType) : void
    {
        if (!$propertyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return;
        }
        if (!$propertyType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->yes()) {
            return;
        }
        $onlyProperty = $property->props[0];
        // skip is already has value
        if ($onlyProperty->default !== null) {
            return;
        }
        $onlyProperty->default = $this->createNull();
    }
    private function isNonBasicArrayType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode $varTagValueNode) : bool
    {
        if ($varTagValueNode->type instanceof \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode) {
            foreach ($varTagValueNode->type->types as $type) {
                if ($type instanceof \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode && \class_exists((string) $type->type)) {
                    return \true;
                }
            }
        }
        if (!$this->isArrayTypeNode($varTagValueNode)) {
            return \false;
        }
        $varTypeDocString = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPhpDocString($varTagValueNode->type, $property);
        return $varTypeDocString !== 'array';
    }
    private function isArrayTypeNode(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode $varTagValueNode) : bool
    {
        return $varTagValueNode->type instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
    }
}
