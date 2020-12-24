<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Constant;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\CompoundType;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
class ConstantFloatType extends \_PhpScopere8e811afab72\PHPStan\Type\FloatType implements \_PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType
{
    use ConstantScalarTypeTrait;
    use ConstantScalarToBooleanTrait;
    /** @var float */
    private $value;
    public function __construct(float $value)
    {
        $this->value = $value;
    }
    public function getValue() : float
    {
        return $this->value;
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'float';
        }, function () : string {
            $formatted = (string) $this->value;
            if (\strpos($formatted, '.') === \false) {
                $formatted .= '.0';
            }
            return $formatted;
        });
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            if (!$this->equals($type)) {
                if ($this->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()) === $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())) {
                    return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
                }
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
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
