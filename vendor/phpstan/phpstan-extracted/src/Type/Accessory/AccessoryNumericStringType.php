<?php

declare (strict_types=1);
namespace PHPStan\Type\Accessory;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\CompoundTypeHelper;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\StringType;
use PHPStan\Type\Traits\NonCallableTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\NonIterableTypeTrait;
use PHPStan\Type\Traits\NonObjectTypeTrait;
use PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class AccessoryNumericStringType implements \PHPStan\Type\CompoundType, \PHPStan\Type\Accessory\AccessoryType
{
    use NonCallableTypeTrait;
    use NonObjectTypeTrait;
    use NonIterableTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    use NonGenericTypeTrait;
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $type->isNumericString();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($this->equals($type)) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        return $type->isNumericString();
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\UnionType || $otherType instanceof \PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isNumericString()->and($otherType instanceof self ? \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes() : \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'numeric';
    }
    public function isOffsetAccessible() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return (new \PHPStan\Type\IntegerType())->isSuperTypeOf($offsetType)->and(\RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe());
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
        return $this;
    }
    public function isArray() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\UnionType([$this->toInteger(), $this->toFloat()]);
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
    public function isNumericString() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        return $this;
    }
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self();
    }
}
