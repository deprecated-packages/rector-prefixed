<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ParentStaticType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
final class IdentifierTypeMapper implements \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var ScalarStringToTypeMapper
     */
    private $scalarStringToTypeMapper;
    /**
     * @var ObjectTypeSpecifier
     */
    private $objectTypeSpecifier;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper $scalarStringToTypeMapper)
    {
        $this->scalarStringToTypeMapper = $scalarStringToTypeMapper;
        $this->objectTypeSpecifier = $objectTypeSpecifier;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class;
    }
    /**
     * @param AttributeAwareIdentifierTypeNode&IdentifierTypeNode $typeNode
     */
    public function mapToPHPStanType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $type = $this->scalarStringToTypeMapper->mapScalarStringToType($typeNode->name);
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType || $type->isExplicitMixed()) {
            return $type;
        }
        $loweredName = \strtolower($typeNode->name);
        if ($loweredName === 'class-string') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType();
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
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        }
        $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($typeNode->name);
        return $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, $objectType);
    }
    private function mapSelf(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            // self outside the class, e.g. in a function
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType($className);
    }
    private function mapParent(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var string|null $parentClassName */
        $parentClassName = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ParentStaticType($parentClassName);
    }
    private function mapStatic(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType($className);
    }
}
