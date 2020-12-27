<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Traits\NonCallableTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\NonIterableTypeTrait;
use PHPStan\Type\Traits\NonObjectTypeTrait;
use PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class BooleanType implements \PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'bool';
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return $this->toInteger();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantStringType(''), new \PHPStan\Type\Constant\ConstantStringType('1'));
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1));
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantFloatType(0.0), new \PHPStan\Type\Constant\ConstantFloatType(1.0));
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self();
    }
}
