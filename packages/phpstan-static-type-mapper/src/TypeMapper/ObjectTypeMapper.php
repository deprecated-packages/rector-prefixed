<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class ObjectTypeMapper implements \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface, \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    public function getNodeClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType::class;
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
            return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType) {
            return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType) {
            $identifierTypeNode = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('\\' . $type->getClassName());
            $genericTypeNodes = [];
            foreach ($type->getTypes() as $genericType) {
                $typeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($genericType);
                $genericTypeNodes[] = $typeNode;
            }
            return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode($identifierTypeNode, $genericTypeNodes);
        }
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('\\' . $type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPhpParserNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('self');
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($type->getFullyQualifiedName());
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($type->getClassName());
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($type->getClassName());
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType && $type->getClassName() === 'object') {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('object');
        }
        // fallback
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToDocString(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $parentType = null) : string
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType) {
            // no preslash for alias
            return $type->getClassName();
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
            return '\\' . $type->getFullyQualifiedName();
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            // always prefixed with \\
            return '\\' . $type->getClassName();
        }
        if (\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($type->getClassName())) {
            // FQN by default
            return '\\' . $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly());
        }
        return $type->getClassName();
    }
    public function setPHPStanStaticTypeMapper(\_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
}
