<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\CompoundTypeHelper;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\Type;
trait ConstantScalarTypeTrait
{
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($this->value === $type->value);
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes() : \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->value === $type->value;
    }
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\ConstantScalarType) {
            if ($orEqual) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($this->value <= $otherType->getValue());
            }
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($this->value < $otherType->getValue());
        }
        if ($otherType instanceof \PHPStan\Type\CompoundType) {
            return $otherType->isGreaterThan($this, $orEqual);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function generalize() : \PHPStan\Type\Type
    {
        return new parent();
    }
}
