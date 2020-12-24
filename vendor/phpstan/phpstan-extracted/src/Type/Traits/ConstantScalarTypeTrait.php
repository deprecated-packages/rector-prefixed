<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Traits;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
trait ConstantScalarTypeTrait
{
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($this->value === $type->value);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->value === $type->value;
    }
    public function isSmallerThan(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType) {
            if ($orEqual) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($this->value <= $otherType->getValue());
            }
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($this->value < $otherType->getValue());
        }
        if ($otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $otherType->isGreaterThan($this, $orEqual);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function generalize() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new parent();
    }
}
