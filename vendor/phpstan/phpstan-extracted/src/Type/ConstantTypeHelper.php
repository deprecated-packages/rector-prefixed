<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
class ConstantTypeHelper
{
    /**
     * @param mixed $value
     */
    public static function getTypeFromValue($value) : \PHPStan\Type\Type
    {
        if (\is_int($value)) {
            return new \PHPStan\Type\Constant\ConstantIntegerType($value);
        } elseif (\is_float($value)) {
            return new \PHPStan\Type\Constant\ConstantFloatType($value);
        } elseif (\is_bool($value)) {
            return new \PHPStan\Type\Constant\ConstantBooleanType($value);
        } elseif ($value === null) {
            return new \PHPStan\Type\NullType();
        } elseif (\is_string($value)) {
            return new \PHPStan\Type\Constant\ConstantStringType($value);
        } elseif (\is_array($value)) {
            $arrayBuilder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($value as $k => $v) {
                $arrayBuilder->setOffsetValueType(self::getTypeFromValue($k), self::getTypeFromValue($v));
            }
            return $arrayBuilder->getArray();
        }
        return new \PHPStan\Type\MixedType();
    }
}
