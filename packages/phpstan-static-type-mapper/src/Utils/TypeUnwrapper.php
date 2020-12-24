<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils;

use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper;
final class TypeUnwrapper
{
    /**
     * E.g. null|ClassType → ClassType
     */
    public function unwrapNullableType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $type;
        }
        if (\count($type->getTypes()) !== 2) {
            return $type;
        }
        if (!$type->isSuperTypeOf(new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType())->yes()) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    public function unwrapFirstObjectTypeFromUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $type;
        }
        foreach ($type->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            return $unionedType;
        }
        return $type;
    }
    /**
     * @return Type|UnionType
     */
    public function removeNullTypeFromUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $unionedTypesWithoutNullType = [];
        foreach ($unionType->getTypes() as $type) {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
                continue;
            }
            $unionedTypesWithoutNullType[] = $type;
        }
        return \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($unionedTypesWithoutNullType);
    }
}
