<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Broker\Broker;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Traits\MaybeCallableTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\NonIterableTypeTrait;
use PHPStan\Type\Traits\NonObjectTypeTrait;
use PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class StringType implements \PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use MaybeCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'string';
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        return (new \PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->and(\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        if ($this->hasOffsetValueType($offsetType)->no()) {
            return new \PHPStan\Type\ErrorType();
        }
        return new \PHPStan\Type\StringType();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        if ($offsetType === null) {
            return new \PHPStan\Type\ErrorType();
        }
        $valueStringType = $valueType->toString();
        if ($valueStringType instanceof \PHPStan\Type\ErrorType) {
            return new \PHPStan\Type\ErrorType();
        }
        if ((new \PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->yes() || $offsetType instanceof \PHPStan\Type\MixedType) {
            return new \PHPStan\Type\StringType();
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \PHPStan\Type\TypeWithClassName && !$strictTypes) {
            $broker = \PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getClassName())) {
                return \PHPStan\TrinaryLogic::createNo();
            }
            $typeClass = $broker->getClass($type->getClassName());
            return \PHPStan\TrinaryLogic::createFromBoolean($typeClass->hasNativeMethod('__toString'));
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\IntegerType();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\FloatType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return $this;
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
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
