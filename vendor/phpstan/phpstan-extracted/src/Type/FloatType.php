<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Traits\NonCallableTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\NonIterableTypeTrait;
use PHPStan\Type\Traits\NonObjectTypeTrait;
use PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class FloatType implements \PHPStan\Type\Type
{
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    use NonGenericTypeTrait;
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self || $type instanceof \PHPStan\Type\IntegerType) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy(new \PHPStan\Type\UnionType([$this, new \PHPStan\Type\IntegerType()]), $strictTypes);
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
        return \get_class($type) === static::class;
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'float';
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return $this;
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return $this;
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\IntegerType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Accessory\AccessoryNumericStringType()]);
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
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        return $this;
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
