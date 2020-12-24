<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Constant;

use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
class ConstantBooleanType extends \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType implements \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType
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
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $this->value ? 'true' : 'false';
    }
    public function toBoolean() : \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType
    {
        return $this;
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
    }
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
    }
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType((float) $this->value);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($properties['value']);
    }
}
