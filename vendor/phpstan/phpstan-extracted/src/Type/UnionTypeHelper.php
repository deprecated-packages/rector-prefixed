<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
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
        \usort($types, static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $a, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $b) : int {
            if ($a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType) {
                return 1;
            } elseif ($b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType) {
                return -1;
            }
            if ($a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryType) {
                if ($b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryType) {
                    return \strcasecmp($a->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $b->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()));
                }
                return 1;
            }
            if ($b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryType) {
                return -1;
            }
            $aIsBool = $a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
            $bIsBool = $b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
            if ($aIsBool && !$bIsBool) {
                return 1;
            } elseif ($bIsBool && !$aIsBool) {
                return -1;
            }
            if ($a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType && !$b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType) {
                return -1;
            } elseif (!$a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType && $b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType) {
                return 1;
            }
            if (($a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType || $a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType) && ($b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType || $b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType)) {
                $cmp = $a->getValue() <=> $b->getValue();
                if ($cmp !== 0) {
                    return $cmp;
                }
                if ($a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType && $b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType) {
                    return -1;
                }
                if ($b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType && $a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType) {
                    return 1;
                }
                return 0;
            }
            if ($a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType && $b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType) {
                return $a->getMin() <=> $b->getMin();
            }
            if ($a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType && $b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
                return \strcasecmp($a->getValue(), $b->getValue());
            }
            if ($a instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType && $b instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType) {
                if ($a->isEmpty()) {
                    if ($b->isEmpty()) {
                        return 0;
                    }
                    return -1;
                } elseif ($b->isEmpty()) {
                    return 1;
                }
                return \strcasecmp($a->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $b->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()));
            }
            return \strcasecmp($a->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::typeOnly()), $b->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::typeOnly()));
        });
        return $types;
    }
}
