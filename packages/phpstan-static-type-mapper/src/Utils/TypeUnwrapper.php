<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\Utils;

use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\PHPStan\TypeFactoryStaticHelper;
final class TypeUnwrapper
{
    /**
     * E.g. null|ClassType → ClassType
     */
    public function unwrapNullableType(\PHPStan\Type\UnionType $unionType) : ?\PHPStan\Type\Type
    {
        if (\count($unionType->getTypes()) !== 2) {
            return null;
        }
        if (!$unionType->isSuperTypeOf(new \PHPStan\Type\NullType())->yes()) {
            return null;
        }
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \PHPStan\Type\NullType) {
                continue;
            }
            return $unionedType;
        }
        return null;
    }
    public function unwrapFirstObjectTypeFromUnionType(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if (!$type instanceof \PHPStan\Type\UnionType) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if (!$unionedType instanceof \PHPStan\Type\TypeWithClassName) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    /**
     * @return Type|UnionType
     */
    public function removeNullTypeFromUnionType(\PHPStan\Type\UnionType $unionType) : \PHPStan\Type\Type
    {
        $unionedTypesWithoutNullType = [];
        foreach ($unionType->getTypes() as $type) {
            if ($type instanceof \PHPStan\Type\UnionType) {
                continue;
            }
            $unionedTypesWithoutNullType[] = $type;
        }
        return \Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($unionedTypesWithoutNullType);
    }
}
