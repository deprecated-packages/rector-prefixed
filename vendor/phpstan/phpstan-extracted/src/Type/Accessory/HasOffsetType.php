<?php

declare (strict_types=1);
namespace PHPStan\Type\Accessory;

use PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\CompoundTypeHelper;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Traits\MaybeCallableTypeTrait;
use PHPStan\Type\Traits\MaybeIterableTypeTrait;
use PHPStan\Type\Traits\MaybeObjectTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class HasOffsetType implements \PHPStan\Type\CompoundType, \PHPStan\Type\Accessory\AccessoryType
{
    use MaybeCallableTypeTrait;
    use MaybeIterableTypeTrait;
    use MaybeObjectTypeTrait;
    use TruthyBooleanTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var \PHPStan\Type\Type */
    private $offsetType;
    public function __construct(\PHPStan\Type\Type $offsetType)
    {
        $this->offsetType = $offsetType;
    }
    public function getOffsetType() : \PHPStan\Type\Type
    {
        return $this->offsetType;
    }
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $type->isOffsetAccessible()->and($type->hasOffsetValueType($this->offsetType));
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($this->equals($type)) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        return $type->isOffsetAccessible()->and($type->hasOffsetValueType($this->offsetType));
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\UnionType || $otherType instanceof \PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isOffsetAccessible()->and($otherType->hasOffsetValueType($this->offsetType))->and($otherType instanceof self ? \PHPStan\TrinaryLogic::createYes() : \PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->offsetType->equals($type->offsetType);
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('hasOffset(%s)', $this->offsetType->describe($level));
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        if ($offsetType instanceof \PHPStan\Type\ConstantScalarType && $offsetType->equals($this->offsetType)) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return $this;
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        return $this;
    }
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['offsetType']);
    }
}
