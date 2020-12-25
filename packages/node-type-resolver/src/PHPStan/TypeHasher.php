<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PHPStan;

use PHPStan\ShouldNotHappenException;
use PHPStan\Type\ArrayType;
use PHPStan\Type\ConstantType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
final class TypeHasher
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    public function __construct(\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper)
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    public function createTypeHash(\PHPStan\Type\Type $type) : string
    {
        if ($type instanceof \PHPStan\Type\MixedType) {
            return \serialize($type);
        }
        if ($type instanceof \PHPStan\Type\ArrayType) {
            return $this->createTypeHash($type->getItemType()) . '[]';
        }
        if ($type instanceof \PHPStan\Type\Generic\GenericObjectType) {
            return $this->phpStanStaticTypeMapper->mapToDocString($type);
        }
        if ($type instanceof \PHPStan\Type\TypeWithClassName) {
            return $this->resolveUniqueTypeWithClassNameHash($type);
        }
        if ($type instanceof \PHPStan\Type\ConstantType) {
            if (\method_exists($type, 'getValue')) {
                return \get_class($type) . $type->getValue();
            }
            throw new \PHPStan\ShouldNotHappenException();
        }
        if ($type instanceof \PHPStan\Type\UnionType) {
            return $this->createUnionTypeHash($type);
        }
        return $this->phpStanStaticTypeMapper->mapToDocString($type);
    }
    public function areTypesEqual(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        return $this->createTypeHash($firstType) === $this->createTypeHash($secondType);
    }
    private function resolveUniqueTypeWithClassNameHash(\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        if ($typeWithClassName instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            return $typeWithClassName->getFullyQualifiedClass();
        }
        return $typeWithClassName->getClassName();
    }
    private function createUnionTypeHash(\PHPStan\Type\UnionType $unionType) : string
    {
        $unionedTypesHashes = [];
        foreach ($unionType->getTypes() as $unionedType) {
            $unionedTypesHashes[] = $this->createTypeHash($unionedType);
        }
        \sort($unionedTypesHashes);
        $unionedTypesHashes = \array_unique($unionedTypesHashes);
        return \implode('|', $unionedTypesHashes);
    }
}
