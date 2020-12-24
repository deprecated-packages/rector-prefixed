<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Constant;

use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
class ConstantBooleanType extends \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType implements \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType
{
    use ConstantScalarTypeTrait;
    /** @var bool */
    private $value;
    public function __construct(bool $value)
    {
        $this->value = $value;
    }
    public function getValue() : bool
    {
        return $this->value;
    }
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $this->value ? 'true' : 'false';
    }
    public function toBoolean() : \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType
    {
        return $this;
    }
    public function toNumber() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
    }
    public function toString() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    public function toInteger() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
    }
    public function toFloat() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType((float) $this->value);
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
