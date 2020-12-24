<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Constant;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\CompoundType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
class ConstantFloatType extends \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType implements \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType
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
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
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
    public function isSuperTypeOf(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            if (!$this->equals($type)) {
                if ($this->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()) === $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())) {
                    return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
                }
                return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
            }
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function toString() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    public function toInteger() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new self($properties['value']);
    }
}
