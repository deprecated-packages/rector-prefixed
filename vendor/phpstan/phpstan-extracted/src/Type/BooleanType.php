<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonCallableTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonIterableTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class BooleanType implements \_PhpScopere8e811afab72\PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'bool';
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->toInteger();
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType(''), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('1'));
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(1));
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType(0.0), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType(1.0));
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self();
    }
}
