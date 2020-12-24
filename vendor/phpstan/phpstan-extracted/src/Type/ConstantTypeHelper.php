<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
class ConstantTypeHelper
{
    /**
     * @param mixed $value
     */
    public static function getTypeFromValue($value) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\is_int($value)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType($value);
        } elseif (\is_float($value)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType($value);
        } elseif (\is_bool($value)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType($value);
        } elseif ($value === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        } elseif (\is_string($value)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType($value);
        } elseif (\is_array($value)) {
            $arrayBuilder = \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($value as $k => $v) {
                $arrayBuilder->setOffsetValueType(self::getTypeFromValue($k), self::getTypeFromValue($v));
            }
            return $arrayBuilder->getArray();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
