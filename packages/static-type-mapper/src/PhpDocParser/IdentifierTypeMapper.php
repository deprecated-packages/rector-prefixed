<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\NameScope;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ClassStringType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StaticType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ParentStaticType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\SelfObjectType;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
final class IdentifierTypeMapper implements \_PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var ScalarStringToTypeMapper
     */
    private $scalarStringToTypeMapper;
    /**
     * @var ObjectTypeSpecifier
     */
    private $objectTypeSpecifier;
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper $scalarStringToTypeMapper)
    {
        $this->scalarStringToTypeMapper = $scalarStringToTypeMapper;
        $this->objectTypeSpecifier = $objectTypeSpecifier;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class;
    }
    /**
     * @param AttributeAwareIdentifierTypeNode&IdentifierTypeNode $typeNode
     */
    public function mapToPHPStanType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\NameScope $nameScope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->scalarStringToTypeMapper->mapScalarStringToType($typeNode->name);
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType || $type->isExplicitMixed()) {
            return $type;
        }
        $loweredName = \strtolower($typeNode->name);
        if ($loweredName === 'class-string') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ClassStringType();
        }
        if ($loweredName === 'self') {
            return $this->mapSelf($node);
        }
        if ($loweredName === 'parent') {
            return $this->mapParent($node);
        }
        if ($loweredName === 'static') {
            return $this->mapStatic($node);
        }
        if ($loweredName === 'iterable') {
            return new \_PhpScopere8e811afab72\PHPStan\Type\IterableType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        }
        $objectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($typeNode->name);
        return $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, $objectType);
    }
    private function mapSelf(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            // self outside the class, e.g. in a function
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return new \_PhpScopere8e811afab72\Rector\PHPStan\Type\SelfObjectType($className);
    }
    private function mapParent(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var string|null $parentClassName */
        $parentClassName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return new \_PhpScopere8e811afab72\Rector\PHPStan\Type\ParentStaticType($parentClassName);
    }
    private function mapStatic(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\StaticType($className);
    }
}
