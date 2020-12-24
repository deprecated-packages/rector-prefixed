<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Constant;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\CompoundType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
class ConstantIntegerType extends \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType implements \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType
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
    public function isSuperTypeOf(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createYes() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType) {
            if ($type->getMin() <= $this->value && $this->value <= $type->getMax()) {
                return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'int';
        }, function () : string {
            return \sprintf('%s', $this->value);
        });
    }
    public function toFloat() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType($this->value);
    }
    public function toString() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
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
