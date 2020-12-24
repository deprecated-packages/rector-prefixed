<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Accessory;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeIterableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeObjectTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
class HasOffsetType implements \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType, \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryType
{
    use MaybeCallableTypeTrait;
    use MaybeIterableTypeTrait;
    use MaybeObjectTypeTrait;
    use TruthyBooleanTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var \PHPStan\Type\Type */
    private $offsetType;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType)
    {
        $this->offsetType = $offsetType;
    }
    public function getOffsetType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->offsetType;
    }
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return $type->isOffsetAccessible()->and($type->hasOffsetValueType($this->offsetType));
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($this->equals($type)) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        return $type->isOffsetAccessible()->and($type->hasOffsetValueType($this->offsetType));
    }
    public function isSubTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return $otherType->isOffsetAccessible()->and($otherType->hasOffsetValueType($this->offsetType))->and($otherType instanceof self ? \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isAcceptedBy(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->offsetType->equals($type->offsetType);
    }
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('hasOffset(%s)', $this->offsetType->describe($level));
    }
    public function isOffsetAccessible() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType && $offsetType->equals($this->offsetType)) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this;
    }
    public function isIterableAtLeastOnce() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function isArray() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    public function traverse(callable $cb) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this;
    }
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($properties['offsetType']);
    }
}
