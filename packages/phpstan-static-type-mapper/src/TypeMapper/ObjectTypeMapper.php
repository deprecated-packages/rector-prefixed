<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class ObjectTypeMapper implements \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    public function getNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType::class;
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType) {
            return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType) {
            $identifierTypeNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('\\' . $type->getClassName());
            $genericTypeNodes = [];
            foreach ($type->getTypes() as $genericType) {
                $typeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($genericType);
                $genericTypeNodes[] = $typeNode;
            }
            return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode($identifierTypeNode, $genericTypeNodes);
        }
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('\\' . $type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPhpParserNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\SelfObjectType) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('self');
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($type->getFullyQualifiedName());
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($type->getClassName());
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($type->getClassName());
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType && $type->getClassName() === 'object') {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('object');
        }
        // fallback
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToDocString(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $parentType = null) : string
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType) {
            // no preslash for alias
            return $type->getClassName();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return '\\' . $type->getFullyQualifiedName();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            // always prefixed with \\
            return '\\' . $type->getClassName();
        }
        if (\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($type->getClassName())) {
            // FQN by default
            return '\\' . $type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly());
        }
        return $type->getClassName();
    }
    public function setPHPStanStaticTypeMapper(\_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
}
