<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
class StaticTypeFactory
{
    public static function falsey() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        static $falsey;
        if ($falsey === null) {
            $falsey = new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType(0.0), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType(''), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType('0'), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType([], [])]);
        }
        return $falsey;
    }
    public static function truthy() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        static $truthy;
        if ($truthy === null) {
            $truthy = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(\false, self::falsey());
        }
        return $truthy;
    }
}
