<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
use Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedGenericObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
final class ObjectTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface, \Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\ObjectType::class;
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\PHPStan\Type\Type $type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            return new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($type->getClassName());
        }
        if ($type instanceof \PHPStan\Type\Generic\GenericObjectType) {
            return $this->mapGenericObjectType($type);
        }
        return new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('\\' . $type->getClassName());
    }
    /**
     * @param ObjectType $type
     */
    public function mapToPhpParserNode(\PHPStan\Type\Type $type, ?string $kind = null) : ?\PhpParser\Node
    {
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType) {
            return new \PhpParser\Node\Name('self');
        }
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return new \PhpParser\Node\Name\FullyQualified($type->getFullyQualifiedName());
        }
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            return new \PhpParser\Node\Name($type->getClassName());
        }
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType) {
            return new \PhpParser\Node\Name\FullyQualified($type->getClassName());
        }
        if (!$type instanceof \PHPStan\Type\Generic\GenericObjectType) {
            // fallback
            return new \PhpParser\Node\Name\FullyQualified($type->getClassName());
        }
        if ($type->getClassName() === 'iterable') {
            // fallback
            return new \PhpParser\Node\Name('iterable');
        }
        if ($type->getClassName() !== 'object') {
            // fallback
            return new \PhpParser\Node\Name\FullyQualified($type->getClassName());
        }
        return new \PhpParser\Node\Name('object');
    }
    /**
     * @param ObjectType $type
     * @param \PHPStan\Type\Type|null $parentType
     */
    public function mapToDocString(\PHPStan\Type\Type $type, $parentType = null) : string
    {
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            // no preslash for alias
            return $type->getClassName();
        }
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return '\\' . $type->getFullyQualifiedName();
        }
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType) {
            // always prefixed with \\
            return '\\' . $type->getClassName();
        }
        if ($this->reflectionProvider->hasClass($type->getClassName())) {
            // FQN by default
            return '\\' . $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
        }
        return $type->getClassName();
    }
    public function setPHPStanStaticTypeMapper(\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    private function mapGenericObjectType(\PHPStan\Type\Generic\GenericObjectType $genericObjectType) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $name = $this->resolveGenericObjectTypeName($genericObjectType);
        $identifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($name);
        $genericTypeNodes = [];
        foreach ($genericObjectType->getTypes() as $key => $genericType) {
            // mixed type on 1st item in iterator has no value
            if ($name === 'Iterator' && $genericType instanceof \PHPStan\Type\MixedType && $key === 0) {
                continue;
            }
            $typeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($genericType);
            $genericTypeNodes[] = $typeNode;
        }
        if ($genericTypeNodes === []) {
            return $identifierTypeNode;
        }
        return new \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode($identifierTypeNode, $genericTypeNodes);
    }
    private function resolveGenericObjectTypeName(\PHPStan\Type\Generic\GenericObjectType $genericObjectType) : string
    {
        if ($genericObjectType instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedGenericObjectType) {
            return '\\' . $genericObjectType->getClassName();
        }
        if (\RectorPrefix20210408\Nette\Utils\Strings::contains($genericObjectType->getClassName(), '\\')) {
            return '\\' . $genericObjectType->getClassName();
        }
        return $genericObjectType->getClassName();
    }
}
