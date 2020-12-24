<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
class ConstantIntegerType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType
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
    public function isSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType) {
            if ($type->getMin() <= $this->value && $this->value <= $type->getMax()) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'int';
        }, function () : string {
            return \sprintf('%s', $this->value);
        });
    }
    public function toFloat() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType($this->value);
    }
    public function toString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new self($properties['value']);
    }
}
