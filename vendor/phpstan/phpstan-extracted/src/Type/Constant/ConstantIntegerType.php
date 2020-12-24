<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Constant;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\CompoundType;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
class ConstantIntegerType extends \_PhpScopere8e811afab72\PHPStan\Type\IntegerType implements \_PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType
{
    use ConstantScalarTypeTrait;
    use ConstantScalarToBooleanTrait;
    /** @var int */
    private $value;
    public function __construct(int $value)
    {
        $this->value = $value;
    }
    public function getValue() : int
    {
        return $this->value;
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType) {
            if ($type->getMin() <= $this->value && $this->value <= $type->getMax()) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'int';
        }, function () : string {
            return \sprintf('%s', $this->value);
        });
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType($this->value);
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['value']);
    }
}
