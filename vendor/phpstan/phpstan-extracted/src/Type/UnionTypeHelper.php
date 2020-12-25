<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Type\Accessory\AccessoryType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
class UnionTypeHelper
{
    /**
     * @param \PHPStan\Type\Type[] $types
     * @return string[]
     */
    public static function getReferencedClasses(array $types) : array
    {
        $subTypeClasses = [];
        foreach ($types as $type) {
            $subTypeClasses[] = $type->getReferencedClasses();
        }
        return \array_merge(...$subTypeClasses);
    }
    /**
     * @param \PHPStan\Type\Type[] $types
     * @return \PHPStan\Type\Type[]
     */
    public static function sortTypes(array $types) : array
    {
        \usort($types, static function (\PHPStan\Type\Type $a, \PHPStan\Type\Type $b) : int {
            if ($a instanceof \PHPStan\Type\NullType) {
                return 1;
            } elseif ($b instanceof \PHPStan\Type\NullType) {
                return -1;
            }
            if ($a instanceof \PHPStan\Type\Accessory\AccessoryType) {
                if ($b instanceof \PHPStan\Type\Accessory\AccessoryType) {
                    return \strcasecmp($a->describe(\PHPStan\Type\VerbosityLevel::value()), $b->describe(\PHPStan\Type\VerbosityLevel::value()));
                }
                return 1;
            }
            if ($b instanceof \PHPStan\Type\Accessory\AccessoryType) {
                return -1;
            }
            $aIsBool = $a instanceof \PHPStan\Type\Constant\ConstantBooleanType;
            $bIsBool = $b instanceof \PHPStan\Type\Constant\ConstantBooleanType;
            if ($aIsBool && !$bIsBool) {
                return 1;
            } elseif ($bIsBool && !$aIsBool) {
                return -1;
            }
            if ($a instanceof \PHPStan\Type\ConstantScalarType && !$b instanceof \PHPStan\Type\ConstantScalarType) {
                return -1;
            } elseif (!$a instanceof \PHPStan\Type\ConstantScalarType && $b instanceof \PHPStan\Type\ConstantScalarType) {
                return 1;
            }
            if (($a instanceof \PHPStan\Type\Constant\ConstantIntegerType || $a instanceof \PHPStan\Type\Constant\ConstantFloatType) && ($b instanceof \PHPStan\Type\Constant\ConstantIntegerType || $b instanceof \PHPStan\Type\Constant\ConstantFloatType)) {
                $cmp = $a->getValue() <=> $b->getValue();
                if ($cmp !== 0) {
                    return $cmp;
                }
                if ($a instanceof \PHPStan\Type\Constant\ConstantIntegerType && $b instanceof \PHPStan\Type\Constant\ConstantFloatType) {
                    return -1;
                }
                if ($b instanceof \PHPStan\Type\Constant\ConstantIntegerType && $a instanceof \PHPStan\Type\Constant\ConstantFloatType) {
                    return 1;
                }
                return 0;
            }
            if ($a instanceof \PHPStan\Type\IntegerRangeType && $b instanceof \PHPStan\Type\IntegerRangeType) {
                return $a->getMin() <=> $b->getMin();
            }
            if ($a instanceof \PHPStan\Type\Constant\ConstantStringType && $b instanceof \PHPStan\Type\Constant\ConstantStringType) {
                return \strcasecmp($a->getValue(), $b->getValue());
            }
            if ($a instanceof \PHPStan\Type\Constant\ConstantArrayType && $b instanceof \PHPStan\Type\Constant\ConstantArrayType) {
                if ($a->isEmpty()) {
                    if ($b->isEmpty()) {
                        return 0;
                    }
                    return -1;
                } elseif ($b->isEmpty()) {
                    return 1;
                }
                return \strcasecmp($a->describe(\PHPStan\Type\VerbosityLevel::value()), $b->describe(\PHPStan\Type\VerbosityLevel::value()));
            }
            return \strcasecmp($a->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $b->describe(\PHPStan\Type\VerbosityLevel::typeOnly()));
        });
        return $types;
    }
}
