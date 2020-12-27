<?php

declare (strict_types=1);
namespace PHPStan\Type\Accessory;

use PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\CompoundTypeHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Traits\MaybeCallableTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\NonObjectTypeTrait;
use PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class NonEmptyArrayType implements \PHPStan\Type\CompoundType, \PHPStan\Type\Accessory\AccessoryType
{
    use MaybeCallableTypeTrait;
    use NonObjectTypeTrait;
    use TruthyBooleanTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $type->isArray()->and($type->isIterableAtLeastOnce());
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($this->equals($type)) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return $type->isArray()->and($type->isIterableAtLeastOnce());
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\UnionType || $otherType instanceof \PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isArray()->and($otherType->isIterableAtLeastOnce())->and($otherType instanceof self ? \PHPStan\TrinaryLogic::createYes() : \PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'nonEmpty';
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
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
    public function isIterable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
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
        return new self();
    }
}
