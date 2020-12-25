<?php

declare (strict_types=1);
namespace PHPStan\Type\Constant;

use PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\FloatType;
use PHPStan\Type\Traits\ConstantScalarTypeTrait;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
class ConstantFloatType extends \PHPStan\Type\FloatType implements \PHPStan\Type\ConstantScalarType
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
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
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
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            if (!$this->equals($type)) {
                if ($this->describe(\PHPStan\Type\VerbosityLevel::value()) === $type->describe(\PHPStan\Type\VerbosityLevel::value())) {
                    return \PHPStan\TrinaryLogic::createMaybe();
                }
                return \PHPStan\TrinaryLogic::createNo();
            }
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['value']);
    }
}
