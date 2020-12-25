<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Traits\FalseyBooleanTypeTrait;
use PHPStan\Type\Traits\NonCallableTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\NonIterableTypeTrait;
use PHPStan\Type\Traits\NonObjectTypeTrait;
class NullType implements \PHPStan\Type\ConstantScalarType
{
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use FalseyBooleanTypeTrait;
    use NonGenericTypeTrait;
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    /**
     * @return null
     */
    public function getValue()
    {
        return null;
    }
    public function generalize() : \PHPStan\Type\Type
    {
        return $this;
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\ConstantScalarType) {
            if ($orEqual) {
                return \PHPStan\TrinaryLogic::createFromBoolean(null <= $otherType->getValue());
            }
            return \PHPStan\TrinaryLogic::createFromBoolean(null < $otherType->getValue());
        }
        if ($otherType instanceof \PHPStan\Type\CompoundType) {
            return $otherType->isGreaterThan($this, $orEqual);
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'null';
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\Constant\ConstantIntegerType(0);
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\Constant\ConstantStringType('');
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return $this->toNumber();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return $this->toNumber()->toFloat();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\Constant\ConstantArrayType([], []);
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
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
        $array = new \PHPStan\Type\Constant\ConstantArrayType([], []);
        return $array->setOffsetValueType($offsetType, $valueType);
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
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
