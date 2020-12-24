<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\NonCallableTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\NonIterableTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class BooleanType implements \_PhpScoper0a6b37af0871\PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'bool';
    }
    public function toNumber() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->toInteger();
    }
    public function toString() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType(''), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType('1'));
    }
    public function toInteger() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType(1));
    }
    public function toFloat() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType(0.0), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType(1.0));
    }
    public function toArray() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isOffsetAccessible() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $offsetType) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $offsetType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $offsetType, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $valueType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new self();
    }
}
