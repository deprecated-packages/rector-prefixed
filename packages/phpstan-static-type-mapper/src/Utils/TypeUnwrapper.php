<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Utils;

use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper;
final class TypeUnwrapper
{
    /**
     * E.g. null|ClassType → ClassType
     */
    public function unwrapNullableType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $type;
        }
        if (\count($type->getTypes()) !== 2) {
            return $type;
        }
        if (!$type->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->yes()) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    public function unwrapFirstObjectTypeFromUnionType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    /**
     * @return Type|UnionType
     */
    public function removeNullTypeFromUnionType(\_PhpScopere8e811afab72\PHPStan\Type\UnionType $unionType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $unionedTypesWithoutNullType = [];
        foreach ($unionType->getTypes() as $type) {
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
                continue;
            }
            $unionedTypesWithoutNullType[] = $type;
        }
        return \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($unionedTypesWithoutNullType);
    }
}
