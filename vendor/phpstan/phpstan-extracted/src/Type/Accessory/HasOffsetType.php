<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundTypeHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\MaybeIterableTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\MaybeObjectTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
class HasOffsetType implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\AccessoryType
{
    use MaybeCallableTypeTrait;
    use MaybeIterableTypeTrait;
    use MaybeObjectTypeTrait;
    use TruthyBooleanTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var \PHPStan\Type\Type */
    private $offsetType;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType)
    {
        $this->offsetType = $offsetType;
    }
    public function getOffsetType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->offsetType;
    }
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $type->isOffsetAccessible()->and($type->hasOffsetValueType($this->offsetType));
    }
    public function isSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($this->equals($type)) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
        }
        return $type->isOffsetAccessible()->and($type->hasOffsetValueType($this->offsetType));
    }
    public function isSubTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $otherType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType || $otherType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isOffsetAccessible()->and($otherType->hasOffsetValueType($this->offsetType))->and($otherType instanceof self ? \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->offsetType->equals($type->offsetType);
    }
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('hasOffset(%s)', $this->offsetType->describe($level));
    }
    public function isOffsetAccessible() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType && $offsetType->equals($this->offsetType)) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
    public function setOffsetValueType(?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $valueType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this;
    }
    public function isIterableAtLeastOnce() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
    }
    public function isArray() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
    }
    public function toNumber() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
    public function traverse(callable $cb) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this;
    }
    public static function __set_state(array $properties) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new self($properties['offsetType']);
    }
}
