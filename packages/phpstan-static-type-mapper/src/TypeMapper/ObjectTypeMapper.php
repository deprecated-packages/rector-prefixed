<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\SelfObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class ObjectTypeMapper implements \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    public function getNodeClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\ObjectType::class;
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType) {
            return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType) {
            $identifierTypeNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('\\' . $type->getClassName());
            $genericTypeNodes = [];
            foreach ($type->getTypes() as $genericType) {
                $typeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($genericType);
                $genericTypeNodes[] = $typeNode;
            }
            return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode($identifierTypeNode, $genericTypeNodes);
        }
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('\\' . $type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\SelfObjectType) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Name('self');
        }
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($type->getFullyQualifiedName());
        }
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Name($type->getClassName());
        }
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($type->getClassName());
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType && $type->getClassName() === 'object') {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Name('object');
        }
        // fallback
        return new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType) {
            // no preslash for alias
            return $type->getClassName();
        }
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return '\\' . $type->getFullyQualifiedName();
        }
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            // always prefixed with \\
            return '\\' . $type->getClassName();
        }
        if (\_PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($type->getClassName())) {
            // FQN by default
            return '\\' . $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
        }
        return $type->getClassName();
    }
    public function setPHPStanStaticTypeMapper(\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
}
