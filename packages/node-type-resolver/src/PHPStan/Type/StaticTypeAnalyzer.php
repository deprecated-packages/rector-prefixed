<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
final class StaticTypeAnalyzer
{
    public function isAlwaysTruableType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \false;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return \false;
        }
        if ($this->isNullable($type)) {
            return \false;
        }
        // always trueish
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return \true;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
            return (bool) $type->getValue();
        }
        if ($this->isScalarType($type)) {
            return \false;
        }
        return $this->isAlwaysTruableUnionType($type);
    }
    private function isNullable(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
                return \true;
            }
        }
        return \false;
    }
    private function isScalarType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
            return \true;
        }
        return $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\BooleanType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\FloatType;
    }
    private function isAlwaysTruableUnionType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        foreach ($type->getTypes() as $unionedType) {
            if (!$this->isAlwaysTruableType($unionedType)) {
                return \false;
            }
        }
        return \true;
    }
}
