<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Traits;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ConstantScalarType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
trait ConstantScalarTypeTrait
{
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($this->value === $type->value);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->value === $type->value;
    }
    public function isSmallerThan(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantScalarType) {
            if ($orEqual) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($this->value <= $otherType->getValue());
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($this->value < $otherType->getValue());
        }
        if ($otherType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return $otherType->isGreaterThan($this, $orEqual);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function generalize() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new parent();
    }
}
