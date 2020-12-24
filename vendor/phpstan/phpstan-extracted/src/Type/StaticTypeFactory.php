<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
class StaticTypeFactory
{
    public static function falsey() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        static $falsey;
        if ($falsey === null) {
            $falsey = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\NullType(), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType(0.0), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType(''), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('0'), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType([], [])]);
        }
        return $falsey;
    }
    public static function truthy() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        static $truthy;
        if ($truthy === null) {
            $truthy = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(\false, self::falsey());
        }
        return $truthy;
    }
}
