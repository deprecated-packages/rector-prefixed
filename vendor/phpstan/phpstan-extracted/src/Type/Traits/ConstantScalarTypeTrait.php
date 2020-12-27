<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\CompoundTypeHelper;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\Type;
trait ConstantScalarTypeTrait
{
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \PHPStan\TrinaryLogic::createFromBoolean($this->value === $type->value);
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \PHPStan\TrinaryLogic::createYes() : \PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->value === $type->value;
    }
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\ConstantScalarType) {
            if ($orEqual) {
                return \PHPStan\TrinaryLogic::createFromBoolean($this->value <= $otherType->getValue());
            }
            return \PHPStan\TrinaryLogic::createFromBoolean($this->value < $otherType->getValue());
        }
        if ($otherType instanceof \PHPStan\Type\CompoundType) {
            return $otherType->isGreaterThan($this, $orEqual);
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function generalize() : \PHPStan\Type\Type
    {
        return new parent();
    }
}
