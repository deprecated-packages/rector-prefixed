<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan;

use _PhpScopere8e811afab72\PHPStan\ShouldNotHappenException;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class TypeHasher
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    public function __construct(\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper)
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    public function createTypeHash(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : string
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \serialize($type);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return $this->createTypeHash($type->getItemType()) . '[]';
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType) {
            return $this->phpStanStaticTypeMapper->mapToDocString($type);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return $this->resolveUniqueTypeWithClassNameHash($type);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantType) {
            if (\method_exists($type, 'getValue')) {
                return \get_class($type) . $type->getValue();
            }
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $this->createUnionTypeHash($type);
        }
        return $this->phpStanStaticTypeMapper->mapToDocString($type);
    }
    public function areTypesEqual(\_PhpScopere8e811afab72\PHPStan\Type\Type $firstType, \_PhpScopere8e811afab72\PHPStan\Type\Type $secondType) : bool
    {
        return $this->createTypeHash($firstType) === $this->createTypeHash($secondType);
    }
    private function resolveUniqueTypeWithClassNameHash(\_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        if ($typeWithClassName instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType) {
            return $typeWithClassName->getFullyQualifiedClass();
        }
        return $typeWithClassName->getClassName();
    }
    private function createUnionTypeHash(\_PhpScopere8e811afab72\PHPStan\Type\UnionType $unionType) : string
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
