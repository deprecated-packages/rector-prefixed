<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Broker\Broker;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonIterableTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class StringType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use MaybeCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'string';
    }
    public function isOffsetAccessible() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return (new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->and(\_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->hasOffsetValueType($offsetType)->no()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType();
    }
    public function setOffsetValueType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $valueType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($offsetType === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        $valueStringType = $valueType->toString();
        if ($valueStringType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        if ((new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->yes() || $offsetType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName && !$strictTypes) {
            $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getClassName())) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
            }
            $typeClass = $broker->getClass($type->getClassName());
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($typeClass->hasNativeMethod('__toString'));
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function toNumber() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType();
    }
    public function toFloat() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType();
    }
    public function toString() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this;
    }
    public function toArray() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function isNumericString() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self();
    }
}
