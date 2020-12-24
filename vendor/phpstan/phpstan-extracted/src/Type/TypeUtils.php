<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Type\Accessory\AccessoryType;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\HasPropertyType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
class TypeUtils
{
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\ArrayType[]
     */
    public static function getArrays(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return $type->getAllArrays();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return [$type];
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                    return [];
                }
                foreach (self::getArrays($innerType) as $innerInnerType) {
                    $matchingTypes[] = $innerInnerType;
                }
            }
            return $matchingTypes;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                    continue;
                }
                foreach (self::getArrays($innerType) as $innerInnerType) {
                    $matchingTypes[] = $innerInnerType;
                }
            }
            return $matchingTypes;
        }
        return [];
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Constant\ConstantArrayType[]
     */
    public static function getConstantArrays(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return $type->getAllArrays();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
                    return [];
                }
                foreach (self::getConstantArrays($innerType) as $innerInnerType) {
                    $matchingTypes[] = $innerInnerType;
                }
            }
            return $matchingTypes;
        }
        return [];
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Constant\ConstantStringType[]
     */
    public static function getConstantStrings(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        return self::map(\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType::class, $type, \false);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\ConstantType[]
     */
    public static function getConstantTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        return self::map(\_PhpScopere8e811afab72\PHPStan\Type\ConstantType::class, $type, \false);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\ConstantType[]
     */
    public static function getAnyConstantTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        return self::map(\_PhpScopere8e811afab72\PHPStan\Type\ConstantType::class, $type, \false, \false);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\ArrayType[]
     */
    public static function getAnyArrays(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        return self::map(\_PhpScopere8e811afab72\PHPStan\Type\ArrayType::class, $type, \true, \false);
    }
    public static function generalizeType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantType) {
                return $type->generalize();
            }
            return $traverse($type);
        });
    }
    /**
     * @param Type $type
     * @return string[]
     */
    public static function getDirectClassNames(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return [$type->getClassName()];
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            $classNames = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                    continue;
                }
                $classNames[] = $innerType->getClassName();
            }
            return $classNames;
        }
        return [];
    }
    /**
     * @param Type $type
     * @return \PHPStan\Type\ConstantScalarType[]
     */
    public static function getConstantScalars(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        return self::map(\_PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType::class, $type, \false);
    }
    /**
     * @internal
     * @param Type $type
     * @return ConstantArrayType[]
     */
    public static function getOldConstantArrays(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        return self::map(\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType::class, $type, \false);
    }
    /**
     * @param string $typeClass
     * @param Type $type
     * @param bool $inspectIntersections
     * @param bool $stopOnUnmatched
     * @return mixed[]
     */
    private static function map(string $typeClass, \_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $inspectIntersections, bool $stopOnUnmatched = \true) : array
    {
        if ($type instanceof $typeClass) {
            return [$type];
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof $typeClass) {
                    if ($stopOnUnmatched) {
                        return [];
                    }
                    continue;
                }
                $matchingTypes[] = $innerType;
            }
            return $matchingTypes;
        }
        if ($inspectIntersections && $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof $typeClass) {
                    if ($stopOnUnmatched) {
                        return [];
                    }
                    continue;
                }
                $matchingTypes[] = $innerType;
            }
            return $matchingTypes;
        }
        return [];
    }
    public static function toBenevolentUnion(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType) {
            return $type;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType($type->getTypes());
        }
        return $type;
    }
    /**
     * @param Type $type
     * @return Type[]
     */
    public static function flattenTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return $type->getAllArrays();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($type->getTypes() as $innerType) {
                if ($innerType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
                    foreach ($innerType->getAllArrays() as $array) {
                        $types[] = $array;
                    }
                    continue;
                }
                $types[] = $innerType;
            }
            return $types;
        }
        return [$type];
    }
    public static function findThisType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : ?\_PhpScopere8e811afab72\PHPStan\Type\ThisType
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType) {
            return $type;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $innerType) {
                $thisType = self::findThisType($innerType);
                if ($thisType !== null) {
                    return $thisType;
                }
            }
        }
        return null;
    }
    /**
     * @param Type $type
     * @return HasPropertyType[]
     */
    public static function getHasPropertyTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Accessory\HasPropertyType) {
            return [$type];
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            $hasPropertyTypes = [[]];
            foreach ($type->getTypes() as $innerType) {
                $hasPropertyTypes[] = self::getHasPropertyTypes($innerType);
            }
            return \array_merge(...$hasPropertyTypes);
        }
        return [];
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Accessory\AccessoryType[]
     */
    public static function getAccessoryTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : array
    {
        return self::map(\_PhpScopere8e811afab72\PHPStan\Type\Accessory\AccessoryType::class, $type, \true, \false);
    }
    public static function containsCallable(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if ($type->isCallable()->yes()) {
            return \true;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            foreach ($type->getTypes() as $innerType) {
                if ($innerType->isCallable()->yes()) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
