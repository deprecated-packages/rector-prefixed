<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonCallableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonIterableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class BooleanType implements \_PhpScoperb75b35f52b74\PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'bool';
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->toInteger();
    }
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType(''), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType('1'));
    }
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(1));
    }
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType(0.0), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType(1.0));
    }
    public function toArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isOffsetAccessible() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self();
    }
}
