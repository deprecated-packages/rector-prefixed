<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonIterableTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class StringType implements \_PhpScopere8e811afab72\PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use MaybeCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'string';
    }
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return (new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->and(\_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->hasOffsetValueType($offsetType)->no()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($offsetType === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        $valueStringType = $valueType->toString();
        if ($valueStringType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        if ((new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->yes() || $offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName && !$strictTypes) {
            $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getClassName())) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
            }
            $typeClass = $broker->getClass($type->getClassName());
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($typeClass->hasNativeMethod('__toString'));
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\FloatType();
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
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
