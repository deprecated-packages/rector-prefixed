<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
class StaticTypeFactory
{
    public static function falsey() : \PHPStan\Type\Type
    {
        static $falsey;
        if ($falsey === null) {
            $falsey = new \PHPStan\Type\UnionType([new \PHPStan\Type\NullType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantFloatType(0.0), new \PHPStan\Type\Constant\ConstantStringType(''), new \PHPStan\Type\Constant\ConstantStringType('0'), new \PHPStan\Type\Constant\ConstantArrayType([], [])]);
        }
        return $falsey;
    }
    public static function truthy() : \PHPStan\Type\Type
    {
        static $truthy;
        if ($truthy === null) {
            $truthy = new \PHPStan\Type\MixedType(\false, self::falsey());
        }
        return $truthy;
    }
}
