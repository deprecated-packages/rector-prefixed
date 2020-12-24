<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Utils;

use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\TypeFactoryStaticHelper;
final class TypeUnwrapper
{
    /**
     * E.g. null|ClassType → ClassType
     */
    public function unwrapNullableType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return $type;
        }
        if (\count($type->getTypes()) !== 2) {
            return $type;
        }
        if (!$type->isSuperTypeOf(new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType())->yes()) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    public function unwrapFirstObjectTypeFromUnionType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    /**
     * @return Type|UnionType
     */
    public function removeNullTypeFromUnionType(\_PhpScoper0a6b37af0871\PHPStan\Type\UnionType $unionType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $unionedTypesWithoutNullType = [];
        foreach ($unionType->getTypes() as $type) {
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                continue;
            }
            $unionedTypesWithoutNullType[] = $type;
        }
        return \_PhpScoper0a6b37af0871\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($unionedTypesWithoutNullType);
    }
}
