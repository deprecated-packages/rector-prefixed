<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Traits;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\CompoundType;
use _PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
trait ConstantScalarTypeTrait
{
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->value === $type->value);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->value === $type->value;
    }
    public function isSmallerThan(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType) {
            if ($orEqual) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->value <= $otherType->getValue());
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->value < $otherType->getValue());
        }
        if ($otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $otherType->isGreaterThan($this, $orEqual);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function generalize() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new parent();
    }
}
