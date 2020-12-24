<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryNumericStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\NonCallableTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\NonIterableTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class IntegerType implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'int';
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new self();
    }
    public function toNumber() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this;
    }
    public function toFloat() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType();
    }
    public function toInteger() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this;
    }
    public function toString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryNumericStringType()]);
    }
    public function toArray() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isOffsetAccessible() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $valueType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
}
