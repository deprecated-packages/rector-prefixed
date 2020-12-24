<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Utils;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper;
final class TypeUnwrapper
{
    /**
     * E.g. null|ClassType → ClassType
     */
    public function unwrapNullableType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            return $type;
        }
        if (\count($type->getTypes()) !== 2) {
            return $type;
        }
        if (!$type->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType())->yes()) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    public function unwrapFirstObjectTypeFromUnionType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    /**
     * @return Type|UnionType
     */
    public function removeNullTypeFromUnionType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType $unionType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $unionedTypesWithoutNullType = [];
        foreach ($unionType->getTypes() as $type) {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
                continue;
            }
            $unionedTypesWithoutNullType[] = $type;
        }
        return \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper::createUnionObjectType($unionedTypesWithoutNullType);
    }
}
