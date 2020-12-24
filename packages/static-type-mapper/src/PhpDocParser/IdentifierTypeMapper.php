<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ParentStaticType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier;
final class IdentifierTypeMapper implements \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var ScalarStringToTypeMapper
     */
    private $scalarStringToTypeMapper;
    /**
     * @var ObjectTypeSpecifier
     */
    private $objectTypeSpecifier;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\PHPStan\Type\ObjectTypeSpecifier $objectTypeSpecifier, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper $scalarStringToTypeMapper)
    {
        $this->scalarStringToTypeMapper = $scalarStringToTypeMapper;
        $this->objectTypeSpecifier = $objectTypeSpecifier;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::class;
    }
    /**
     * @param AttributeAwareIdentifierTypeNode&IdentifierTypeNode $typeNode
     */
    public function mapToPHPStanType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->scalarStringToTypeMapper->mapScalarStringToType($typeNode->name);
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType || $type->isExplicitMixed()) {
            return $type;
        }
        $loweredName = \strtolower($typeNode->name);
        if ($loweredName === 'class-string') {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType();
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
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
        }
        $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($typeNode->name);
        return $this->objectTypeSpecifier->narrowToFullyQualifiedOrAliasedObjectType($node, $objectType);
    }
    private function mapSelf(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            // self outside the class, e.g. in a function
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\SelfObjectType($className);
    }
    private function mapParent(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var string|null $parentClassName */
        $parentClassName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ParentStaticType($parentClassName);
    }
    private function mapStatic(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType($className);
    }
}
