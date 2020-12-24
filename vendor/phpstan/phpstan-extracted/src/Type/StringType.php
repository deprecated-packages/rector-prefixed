<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonIterableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class StringType implements \_PhpScoperb75b35f52b74\PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use MaybeCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'string';
    }
    public function isOffsetAccessible() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return (new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->and(\_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->hasOffsetValueType($offsetType)->no()) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
    }
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($offsetType === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        $valueStringType = $valueType->toString();
        if ($valueStringType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        if ((new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->yes() || $offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName && !$strictTypes) {
            $broker = \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getClassName())) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
            }
            $typeClass = $broker->getClass($type->getClassName());
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($typeClass->hasNativeMethod('__toString'));
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType();
    }
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType();
    }
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this;
    }
    public function toArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isNumericString() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
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
