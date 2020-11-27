<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\NullType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class AllowedArrayKeysTypes
{
    public static function getType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\FloatType(), new \PHPStan\Type\BooleanType(), new \PHPStan\Type\NullType()]);
    }
}
