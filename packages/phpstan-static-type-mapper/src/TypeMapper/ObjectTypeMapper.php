<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use Rector\PHPStan\Type\AliasedObjectType;
use Rector\PHPStan\Type\FullyQualifiedObjectType;
use Rector\PHPStan\Type\SelfObjectType;
use Rector\PHPStan\Type\ShortenedObjectType;
use Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class ObjectTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface, \Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    public function getNodeClass() : string
    {
        return \PHPStan\Type\ObjectType::class;
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\PHPStan\Type\Type $type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($type instanceof \Rector\PHPStan\Type\ShortenedObjectType) {
            return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \Rector\PHPStan\Type\AliasedObjectType) {
            return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \PHPStan\Type\Generic\GenericObjectType) {
            $identifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('\\' . $type->getClassName());
            $genericTypeNodes = [];
            foreach ($type->getTypes() as $genericType) {
                $typeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($genericType);
                $genericTypeNodes[] = $typeNode;
            }
            return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode($identifierTypeNode, $genericTypeNodes);
        }
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('\\' . $type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPhpParserNode(\PHPStan\Type\Type $type, ?string $kind = null) : ?\PhpParser\Node
    {
        if ($type instanceof \Rector\PHPStan\Type\SelfObjectType) {
            return new \PhpParser\Node\Name('self');
        }
        if ($type instanceof \Rector\PHPStan\Type\ShortenedObjectType) {
            return new \PhpParser\Node\Name\FullyQualified($type->getFullyQualifiedName());
        }
        if ($type instanceof \Rector\PHPStan\Type\AliasedObjectType) {
            return new \PhpParser\Node\Name($type->getClassName());
        }
        if ($type instanceof \Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return new \PhpParser\Node\Name\FullyQualified($type->getClassName());
        }
        if ($type instanceof \PHPStan\Type\Generic\GenericObjectType && $type->getClassName() === 'object') {
            return new \PhpParser\Node\Name('object');
        }
        // fallback
        return new \PhpParser\Node\Name\FullyQualified($type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToDocString(\PHPStan\Type\Type $type, ?\PHPStan\Type\Type $parentType = null) : string
    {
        if ($type instanceof \Rector\PHPStan\Type\AliasedObjectType) {
            // no preslash for alias
            return $type->getClassName();
        }
        if ($type instanceof \Rector\PHPStan\Type\ShortenedObjectType) {
            return '\\' . $type->getFullyQualifiedName();
        }
        if ($type instanceof \Rector\PHPStan\Type\FullyQualifiedObjectType) {
            // always prefixed with \\
            return '\\' . $type->getClassName();
        }
        if (\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($type->getClassName())) {
            // FQN by default
            return '\\' . $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
        }
        return $type->getClassName();
    }
    public function setPHPStanStaticTypeMapper(\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
}
