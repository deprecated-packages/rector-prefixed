<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\AccessoryType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasOffsetType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType;
class TypeCombinator
{
    private const CONSTANT_SCALAR_UNION_THRESHOLD = 8;
    public static function addNull(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return self::union($type, new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType());
    }
    public static function remove(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $fromType, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $typeToRemove) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($typeToRemove instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            foreach ($typeToRemove->getTypes() as $unionTypeToRemove) {
                $fromType = self::remove($fromType, $unionTypeToRemove);
            }
            return $fromType;
        }
        if ($fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            $innerTypes = [];
            foreach ($fromType->getTypes() as $innerType) {
                $innerTypes[] = self::remove($innerType, $typeToRemove);
            }
            return self::union(...$innerTypes);
        }
        $isSuperType = $typeToRemove->isSuperTypeOf($fromType);
        if ($isSuperType->yes()) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType();
        }
        if ($typeToRemove instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            $typeToRemoveSubtractedType = $typeToRemove->getSubtractedType();
            if ($typeToRemoveSubtractedType !== null) {
                return self::intersect($fromType, $typeToRemoveSubtractedType);
            }
        }
        if ($fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType) {
            if ($typeToRemove instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(!$typeToRemove->getValue());
            }
        } elseif ($fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
            $traversableType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\Traversable::class);
            $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
            if ($typeToRemove->isSuperTypeOf($arrayType)->yes()) {
                return $traversableType;
            }
            if ($typeToRemove->isSuperTypeOf($traversableType)->yes()) {
                return $arrayType;
            }
        } elseif ($fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType || $fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType) {
            if ($fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                $minA = $fromType->getValue();
                $maxA = $fromType->getValue();
            } else {
                $minA = $fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType ? $fromType->getMin() : \PHP_INT_MIN;
                $maxA = $fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType ? $fromType->getMax() : \PHP_INT_MAX;
            }
            if ($typeToRemove instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType) {
                $removeValueMin = $typeToRemove->getMin();
                $removeValueMax = $typeToRemove->getMax();
                if ($minA < $removeValueMin && $removeValueMax < $maxA) {
                    return self::union(\_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($minA, $removeValueMin - 1), \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($removeValueMax + 1, $maxA));
                }
                if ($removeValueMin <= $minA && $minA <= $removeValueMax) {
                    return \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($removeValueMax === \PHP_INT_MAX ? \PHP_INT_MAX : $removeValueMax + 1, $maxA);
                }
                if ($removeValueMin <= $maxA && $maxA <= $removeValueMax) {
                    return \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($minA, $removeValueMin === \PHP_INT_MIN ? \PHP_INT_MIN : $removeValueMin - 1);
                }
            } elseif ($typeToRemove instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                $removeValue = $typeToRemove->getValue();
                if ($minA < $removeValue && $removeValue < $maxA) {
                    return self::union(\_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($minA, $removeValue - 1), \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($removeValue + 1, $maxA));
                }
                if ($removeValue === $minA) {
                    return \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($minA + 1, $maxA);
                }
                if ($removeValue === $maxA) {
                    return \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($minA, $maxA - 1);
                }
            }
        } elseif ($fromType->isArray()->yes()) {
            if ($typeToRemove instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $typeToRemove->isIterableAtLeastOnce()->no()) {
                return self::intersect($fromType, new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType());
            }
            if ($typeToRemove instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType([], []);
            }
            if ($fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $typeToRemove instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasOffsetType) {
                return $fromType->unsetOffset($typeToRemove->getOffsetType());
            }
        } elseif ($fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType) {
            $typeToSubtractFrom = $fromType;
            if ($fromType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType) {
                $typeToSubtractFrom = $fromType->getBound();
            }
            if ($typeToSubtractFrom->isSuperTypeOf($typeToRemove)->yes()) {
                return $fromType->subtract($typeToRemove);
            }
        }
        return $fromType;
    }
    public static function removeNull(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (self::containsNull($type)) {
            return self::remove($type, new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType());
        }
        return $type;
    }
    public static function containsNull(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            foreach ($type->getTypes() as $innerType) {
                if ($innerType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType) {
                    return \true;
                }
            }
            return \false;
        }
        return $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType;
    }
    public static function union(\_PhpScoper0a6b37af0871\PHPStan\Type\Type ...$types) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $benevolentTypes = [];
        // transform A | (B | C) to A | B | C
        for ($i = 0; $i < \count($types); $i++) {
            if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType) {
                foreach ($types[$i]->getTypes() as $benevolentInnerType) {
                    $benevolentTypes[$benevolentInnerType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())] = $benevolentInnerType;
                }
                \array_splice($types, $i, 1, $types[$i]->getTypes());
                continue;
            }
            if (!$types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                continue;
            }
            \array_splice($types, $i, 1, $types[$i]->getTypes());
        }
        $typesCount = \count($types);
        $arrayTypes = [];
        $arrayAccessoryTypes = [];
        $scalarTypes = [];
        $hasGenericScalarTypes = [];
        for ($i = 0; $i < $typesCount; $i++) {
            if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
                unset($types[$i]);
                continue;
            }
            if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType) {
                $type = $types[$i];
                $scalarTypes[\get_class($type)][\md5($type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::cache()))] = $type;
                unset($types[$i]);
                continue;
            }
            if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType) {
                $hasGenericScalarTypes[\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType::class] = \true;
            }
            if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType) {
                $hasGenericScalarTypes[\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType::class] = \true;
            }
            if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType && !$types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType) {
                $hasGenericScalarTypes[\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType::class] = \true;
            }
            if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType && !$types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType) {
                $hasGenericScalarTypes[\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType::class] = \true;
            }
            if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
                $intermediateArrayType = null;
                $intermediateAccessoryTypes = [];
                foreach ($types[$i]->getTypes() as $innerType) {
                    if ($innerType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
                        $intermediateArrayType = $innerType;
                        continue;
                    }
                    if ($innerType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\AccessoryType || $innerType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CallableType) {
                        $intermediateAccessoryTypes[$innerType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::cache())] = $innerType;
                        continue;
                    }
                }
                if ($intermediateArrayType !== null) {
                    $arrayTypes[] = $intermediateArrayType;
                    $arrayAccessoryTypes[] = $intermediateAccessoryTypes;
                    unset($types[$i]);
                    continue;
                }
            }
            if (!$types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
                continue;
            }
            $arrayTypes[] = $types[$i];
            $arrayAccessoryTypes[] = [];
            unset($types[$i]);
        }
        /** @var ArrayType[] $arrayTypes */
        $arrayTypes = $arrayTypes;
        $arrayAccessoryTypesToProcess = [];
        if (\count($arrayAccessoryTypes) > 1) {
            $arrayAccessoryTypesToProcess = \array_values(\array_intersect_key(...$arrayAccessoryTypes));
        } elseif (\count($arrayAccessoryTypes) > 0) {
            $arrayAccessoryTypesToProcess = \array_values($arrayAccessoryTypes[0]);
        }
        $types = \array_values(\array_merge($types, self::processArrayTypes($arrayTypes, $arrayAccessoryTypesToProcess)));
        // simplify string[] | int[] to (string|int)[]
        for ($i = 0; $i < \count($types); $i++) {
            for ($j = $i + 1; $j < \count($types); $j++) {
                if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType && $types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
                    $types[$i] = new \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType(self::union($types[$i]->getIterableKeyType(), $types[$j]->getIterableKeyType()), self::union($types[$i]->getIterableValueType(), $types[$j]->getIterableValueType()));
                    \array_splice($types, $j, 1);
                    continue 2;
                }
            }
        }
        foreach ($scalarTypes as $classType => $scalarTypeItems) {
            if (isset($hasGenericScalarTypes[$classType])) {
                continue;
            }
            if ($classType === \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType::class && \count($scalarTypeItems) === 2) {
                $types[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType();
                continue;
            }
            foreach ($scalarTypeItems as $type) {
                if (\count($scalarTypeItems) > self::CONSTANT_SCALAR_UNION_THRESHOLD) {
                    $types[] = $type->generalize();
                    if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                        continue;
                    }
                    break;
                }
                $types[] = $type;
            }
        }
        // transform A | A to A
        // transform A | never to A
        for ($i = 0; $i < \count($types); $i++) {
            for ($j = $i + 1; $j < \count($types); $j++) {
                if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType) {
                    if ($types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType) {
                        if ($types[$i]->isSuperTypeOf($types[$j])->maybe() || $types[$i]->getMax() + 1 === $types[$j]->getMin() || $types[$j]->getMax() + 1 === $types[$i]->getMin()) {
                            $types[$i] = \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval(\min($types[$i]->getMin(), $types[$j]->getMin()), \max($types[$i]->getMax(), $types[$j]->getMax()));
                            $i--;
                            \array_splice($types, $j, 1);
                            continue 2;
                        }
                    }
                    if ($types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                        $value = $types[$j]->getValue();
                        if ($types[$i]->getMin() === $value + 1) {
                            $types[$i] = \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($value, $types[$i]->getMax());
                            $i--;
                            \array_splice($types, $j, 1);
                            continue 2;
                        }
                        if ($types[$i]->getMax() === $value - 1) {
                            $types[$i] = \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($types[$i]->getMin(), $value);
                            $i--;
                            \array_splice($types, $j, 1);
                            continue 2;
                        }
                    }
                }
                if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType) {
                    $typeWithoutSubtractedTypeA = $types[$i]->getTypeWithoutSubtractedType();
                    if ($typeWithoutSubtractedTypeA instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType && $types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                        $isSuperType = $typeWithoutSubtractedTypeA->isSuperTypeOfMixed($types[$j]);
                    } else {
                        $isSuperType = $typeWithoutSubtractedTypeA->isSuperTypeOf($types[$j]);
                    }
                    if ($isSuperType->yes()) {
                        $subtractedType = null;
                        if ($types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType) {
                            $subtractedType = $types[$j]->getSubtractedType();
                        }
                        $types[$i] = self::intersectWithSubtractedType($types[$i], $subtractedType);
                        \array_splice($types, $j--, 1);
                        continue 1;
                    }
                }
                if ($types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType) {
                    $typeWithoutSubtractedTypeB = $types[$j]->getTypeWithoutSubtractedType();
                    if ($typeWithoutSubtractedTypeB instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType && $types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                        $isSuperType = $typeWithoutSubtractedTypeB->isSuperTypeOfMixed($types[$i]);
                    } else {
                        $isSuperType = $typeWithoutSubtractedTypeB->isSuperTypeOf($types[$i]);
                    }
                    if ($isSuperType->yes()) {
                        $subtractedType = null;
                        if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType) {
                            $subtractedType = $types[$i]->getSubtractedType();
                        }
                        $types[$j] = self::intersectWithSubtractedType($types[$j], $subtractedType);
                        \array_splice($types, $i--, 1);
                        continue 2;
                    }
                }
                if (!$types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $types[$j]->isSuperTypeOf($types[$i])->yes()) {
                    \array_splice($types, $i--, 1);
                    continue 2;
                }
                if (!$types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $types[$i]->isSuperTypeOf($types[$j])->yes()) {
                    \array_splice($types, $j--, 1);
                    continue 1;
                }
            }
        }
        if (\count($types) === 0) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType();
        } elseif (\count($types) === 1) {
            return $types[0];
        }
        if (\count($benevolentTypes) > 0) {
            $tempTypes = $types;
            foreach ($tempTypes as $i => $type) {
                if (!isset($benevolentTypes[$type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())])) {
                    break;
                }
                unset($tempTypes[$i]);
            }
            if (\count($tempTypes) === 0) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType($types);
            }
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType($types);
    }
    private static function unionWithSubtractedType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $subtractedType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($subtractedType === null) {
            return $type;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType) {
            if ($type->getSubtractedType() === null) {
                return $type;
            }
            $subtractedType = self::union($type->getSubtractedType(), $subtractedType);
            if ($subtractedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
                $subtractedType = null;
            }
            return $type->changeSubtractedType($subtractedType);
        }
        if ($subtractedType->isSuperTypeOf($type)->yes()) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType();
        }
        return self::remove($type, $subtractedType);
    }
    private static function intersectWithSubtractedType(\_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType $subtractableType, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $subtractedType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($subtractableType->getSubtractedType() === null) {
            return $subtractableType;
        }
        if ($subtractedType === null) {
            return $subtractableType->getTypeWithoutSubtractedType();
        }
        $subtractedType = self::intersect($subtractableType->getSubtractedType(), $subtractedType);
        if ($subtractedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        return $subtractableType->changeSubtractedType($subtractedType);
    }
    /**
     * @param ArrayType[] $arrayTypes
     * @param Type[] $accessoryTypes
     * @return Type[]
     */
    private static function processArrayTypes(array $arrayTypes, array $accessoryTypes) : array
    {
        foreach ($arrayTypes as $arrayType) {
            if (!$arrayType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType) {
                continue;
            }
            if (\count($arrayType->getKeyTypes()) > 0) {
                continue;
            }
            foreach ($accessoryTypes as $i => $accessoryType) {
                if (!$accessoryType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType) {
                    continue;
                }
                unset($accessoryTypes[$i]);
                break 2;
            }
        }
        if (\count($arrayTypes) === 0) {
            return [];
        } elseif (\count($arrayTypes) === 1) {
            return [self::intersect($arrayTypes[0], ...$accessoryTypes)];
        }
        $keyTypesForGeneralArray = [];
        $valueTypesForGeneralArray = [];
        $generalArrayOccurred = \false;
        $constantKeyTypesNumbered = [];
        /** @var int|float $nextConstantKeyTypeIndex */
        $nextConstantKeyTypeIndex = 1;
        foreach ($arrayTypes as $arrayType) {
            if (!$arrayType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType || $generalArrayOccurred) {
                $keyTypesForGeneralArray[] = $arrayType->getKeyType();
                $valueTypesForGeneralArray[] = $arrayType->getItemType();
                $generalArrayOccurred = \true;
                continue;
            }
            foreach ($arrayType->getKeyTypes() as $i => $keyType) {
                $keyTypesForGeneralArray[] = $keyType;
                $valueTypesForGeneralArray[] = $arrayType->getValueTypes()[$i];
                $keyTypeValue = $keyType->getValue();
                if (\array_key_exists($keyTypeValue, $constantKeyTypesNumbered)) {
                    continue;
                }
                $constantKeyTypesNumbered[$keyTypeValue] = $nextConstantKeyTypeIndex;
                $nextConstantKeyTypeIndex *= 2;
                if (!\is_int($nextConstantKeyTypeIndex)) {
                    $generalArrayOccurred = \true;
                    continue;
                }
            }
        }
        if ($generalArrayOccurred) {
            return [self::intersect(new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(self::union(...$keyTypesForGeneralArray), self::union(...$valueTypesForGeneralArray)), ...$accessoryTypes)];
        }
        /** @var ConstantArrayType[] $arrayTypes */
        $arrayTypes = $arrayTypes;
        /** @var int[] $constantKeyTypesNumbered */
        $constantKeyTypesNumbered = $constantKeyTypesNumbered;
        $constantArraysBuckets = [];
        foreach ($arrayTypes as $arrayTypeAgain) {
            $arrayIndex = 0;
            foreach ($arrayTypeAgain->getKeyTypes() as $keyType) {
                $arrayIndex += $constantKeyTypesNumbered[$keyType->getValue()];
            }
            if (!\array_key_exists($arrayIndex, $constantArraysBuckets)) {
                $bucket = [];
                foreach ($arrayTypeAgain->getKeyTypes() as $i => $keyType) {
                    $bucket[$keyType->getValue()] = ['keyType' => $keyType, 'valueType' => $arrayTypeAgain->getValueTypes()[$i], 'optional' => $arrayTypeAgain->isOptionalKey($i)];
                }
                $constantArraysBuckets[$arrayIndex] = $bucket;
                continue;
            }
            $bucket = $constantArraysBuckets[$arrayIndex];
            foreach ($arrayTypeAgain->getKeyTypes() as $i => $keyType) {
                $bucket[$keyType->getValue()]['valueType'] = self::union($bucket[$keyType->getValue()]['valueType'], $arrayTypeAgain->getValueTypes()[$i]);
                $bucket[$keyType->getValue()]['optional'] = $bucket[$keyType->getValue()]['optional'] || $arrayTypeAgain->isOptionalKey($i);
            }
            $constantArraysBuckets[$arrayIndex] = $bucket;
        }
        $resultArrays = [];
        foreach ($constantArraysBuckets as $bucket) {
            $builder = \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($bucket as $data) {
                $builder->setOffsetValueType($data['keyType'], $data['valueType'], $data['optional']);
            }
            $resultArrays[] = self::intersect($builder->getArray(), ...$accessoryTypes);
        }
        return self::reduceArrays($resultArrays);
    }
    /**
     * @param Type[] $constantArrays
     * @return Type[]
     */
    private static function reduceArrays(array $constantArrays) : array
    {
        $newArrays = [];
        $arraysToProcess = [];
        foreach ($constantArrays as $constantArray) {
            if (!$constantArray instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType) {
                $newArrays[] = $constantArray;
                continue;
            }
            $arraysToProcess[] = $constantArray;
        }
        for ($i = 0; $i < \count($arraysToProcess); $i++) {
            for ($j = $i + 1; $j < \count($arraysToProcess); $j++) {
                if ($arraysToProcess[$j]->isKeysSupersetOf($arraysToProcess[$i])) {
                    $arraysToProcess[$j] = $arraysToProcess[$j]->mergeWith($arraysToProcess[$i]);
                    \array_splice($arraysToProcess, $i--, 1);
                    continue 2;
                } elseif ($arraysToProcess[$i]->isKeysSupersetOf($arraysToProcess[$j])) {
                    $arraysToProcess[$i] = $arraysToProcess[$i]->mergeWith($arraysToProcess[$j]);
                    \array_splice($arraysToProcess, $j--, 1);
                    continue 1;
                }
            }
        }
        return \array_merge($newArrays, $arraysToProcess);
    }
    public static function intersect(\_PhpScoper0a6b37af0871\PHPStan\Type\Type ...$types) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        \usort($types, static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $a, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $b) : int {
            if (!$a instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType || !$b instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                return 0;
            }
            if ($a instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType) {
                return 1;
            }
            if ($b instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType) {
                return -1;
            }
            return 0;
        });
        // transform A & (B | C) to (A & B) | (A & C)
        foreach ($types as $i => $type) {
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                $topLevelUnionSubTypes = [];
                foreach ($type->getTypes() as $innerUnionSubType) {
                    $topLevelUnionSubTypes[] = self::intersect($innerUnionSubType, ...\array_slice($types, 0, $i), ...\array_slice($types, $i + 1));
                }
                $union = self::union(...$topLevelUnionSubTypes);
                if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType) {
                    return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::toBenevolentUnion($union);
                }
                return $union;
            }
        }
        // transform A & (B & C) to A & B & C
        foreach ($types as $i => &$type) {
            if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
                continue;
            }
            \array_splice($types, $i, 1, $type->getTypes());
        }
        // transform IntegerType & ConstantIntegerType to ConstantIntegerType
        // transform Child & Parent to Child
        // transform Object & ~null to Object
        // transform A & A to A
        // transform int[] & string to never
        // transform callable & int to never
        // transform A & ~A to never
        // transform int & string to never
        for ($i = 0; $i < \count($types); $i++) {
            for ($j = $i + 1; $j < \count($types); $j++) {
                if ($types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType) {
                    $typeWithoutSubtractedTypeA = $types[$j]->getTypeWithoutSubtractedType();
                    if ($typeWithoutSubtractedTypeA instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType && $types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                        $isSuperTypeSubtractableA = $typeWithoutSubtractedTypeA->isSuperTypeOfMixed($types[$i]);
                    } else {
                        $isSuperTypeSubtractableA = $typeWithoutSubtractedTypeA->isSuperTypeOf($types[$i]);
                    }
                    if ($isSuperTypeSubtractableA->yes()) {
                        $types[$i] = self::unionWithSubtractedType($types[$i], $types[$j]->getSubtractedType());
                        \array_splice($types, $j--, 1);
                        continue 1;
                    }
                }
                if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\SubtractableType) {
                    $typeWithoutSubtractedTypeB = $types[$i]->getTypeWithoutSubtractedType();
                    if ($typeWithoutSubtractedTypeB instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType && $types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                        $isSuperTypeSubtractableB = $typeWithoutSubtractedTypeB->isSuperTypeOfMixed($types[$j]);
                    } else {
                        $isSuperTypeSubtractableB = $typeWithoutSubtractedTypeB->isSuperTypeOf($types[$j]);
                    }
                    if ($isSuperTypeSubtractableB->yes()) {
                        $types[$j] = self::unionWithSubtractedType($types[$j], $types[$i]->getSubtractedType());
                        \array_splice($types, $i--, 1);
                        continue 2;
                    }
                }
                if ($types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
                    $isSuperTypeA = $types[$j]->isSuperTypeOfMixed($types[$i]);
                } else {
                    $isSuperTypeA = $types[$j]->isSuperTypeOf($types[$i]);
                }
                if ($isSuperTypeA->yes()) {
                    \array_splice($types, $j--, 1);
                    continue;
                }
                if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
                    $isSuperTypeB = $types[$i]->isSuperTypeOfMixed($types[$j]);
                } else {
                    $isSuperTypeB = $types[$i]->isSuperTypeOf($types[$j]);
                }
                if ($isSuperTypeB->maybe()) {
                    if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType && $types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType) {
                        $min = \max($types[$i]->getMin(), $types[$j]->getMin());
                        $max = \min($types[$i]->getMax(), $types[$j]->getMax());
                        $types[$j] = \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval($min, $max);
                        \array_splice($types, $i--, 1);
                        continue 2;
                    }
                    if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasOffsetType) {
                        $types[$i] = $types[$i]->makeOffsetRequired($types[$j]->getOffsetType());
                        \array_splice($types, $j--, 1);
                        continue;
                    }
                    if ($types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\HasOffsetType) {
                        $types[$j] = $types[$j]->makeOffsetRequired($types[$i]->getOffsetType());
                        \array_splice($types, $i--, 1);
                        continue 2;
                    }
                    if (($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType || $types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) && ($types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType || $types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType)) {
                        $keyType = self::intersect($types[$i]->getKeyType(), $types[$j]->getKeyType());
                        $itemType = self::intersect($types[$i]->getItemType(), $types[$j]->getItemType());
                        if ($types[$i] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType && $types[$j] instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
                            $types[$j] = new \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType($keyType, $itemType);
                        } else {
                            $types[$j] = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType($keyType, $itemType);
                        }
                        \array_splice($types, $i--, 1);
                        continue 2;
                    }
                    continue;
                }
                if ($isSuperTypeB->yes()) {
                    \array_splice($types, $i--, 1);
                    continue 2;
                }
                if ($isSuperTypeA->no()) {
                    return new \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType();
                }
            }
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType($types);
    }
}
