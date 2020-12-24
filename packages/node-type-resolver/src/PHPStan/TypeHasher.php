<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan;

use _PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class TypeHasher
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper)
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    public function createTypeHash(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : string
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return \serialize($type);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return $this->createTypeHash($type->getItemType()) . '[]';
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType) {
            return $this->phpStanStaticTypeMapper->mapToDocString($type);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return $this->resolveUniqueTypeWithClassNameHash($type);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantType) {
            if (\method_exists($type, 'getValue')) {
                return \get_class($type) . $type->getValue();
            }
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $this->createUnionTypeHash($type);
        }
        return $this->phpStanStaticTypeMapper->mapToDocString($type);
    }
    public function areTypesEqual(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $firstType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $secondType) : bool
    {
        return $this->createTypeHash($firstType) === $this->createTypeHash($secondType);
    }
    private function resolveUniqueTypeWithClassNameHash(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        if ($typeWithClassName instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType) {
            return $typeWithClassName->getFullyQualifiedClass();
        }
        return $typeWithClassName->getClassName();
    }
    private function createUnionTypeHash(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : string
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
