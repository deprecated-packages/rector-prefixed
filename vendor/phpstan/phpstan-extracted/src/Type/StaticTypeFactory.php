<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
class StaticTypeFactory
{
    public static function falsey() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        static $falsey;
        if ($falsey === null) {
            $falsey = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType(0.0), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType(''), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType('0'), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType([], [])]);
        }
        return $falsey;
    }
    public static function truthy() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        static $truthy;
        if ($truthy === null) {
            $truthy = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(\false, self::falsey());
        }
        return $truthy;
    }
}
