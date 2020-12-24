<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
class StaticTypeFactory
{
    public static function falsey() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        static $falsey;
        if ($falsey === null) {
            $falsey = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType(0.0), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType(''), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType('0'), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType([], [])]);
        }
        return $falsey;
    }
    public static function truthy() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        static $truthy;
        if ($truthy === null) {
            $truthy = new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(\false, self::falsey());
        }
        return $truthy;
    }
}
