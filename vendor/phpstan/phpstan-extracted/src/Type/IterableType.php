<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeObjectTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class IterableType implements \_PhpScopere8e811afab72\PHPStan\Type\CompoundType
{
    use MaybeCallableTypeTrait;
    use MaybeObjectTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var \PHPStan\Type\Type */
    private $keyType;
    /** @var \PHPStan\Type\Type */
    private $itemType;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Type $keyType, \_PhpScopere8e811afab72\PHPStan\Type\Type $itemType)
    {
        $this->keyType = $keyType;
        $this->itemType = $itemType;
    }
    public function getKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->keyType;
    }
    public function getItemType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->itemType;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return \array_merge($this->keyType->getReferencedClasses(), $this->getItemType()->getReferencedClasses());
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType && $type->isEmpty()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($type->isIterable()->yes()) {
            return $this->getIterableValueType()->accepts($type->getIterableValueType(), $strictTypes)->and($this->getIterableKeyType()->accepts($type->getIterableKeyType(), $strictTypes));
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $type->isIterable()->and($this->getIterableValueType()->isSuperTypeOf($type->getIterableValueType()))->and($this->getIterableKeyType()->isSuperTypeOf($type->getIterableKeyType()));
    }
    public function isSuperTypeOfMixed(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $type->isIterable()->and($this->isNestedTypeSuperTypeOf($this->getIterableValueType(), $type->getIterableValueType()))->and($this->isNestedTypeSuperTypeOf($this->getIterableKeyType(), $type->getIterableKeyType()));
    }
    private function isNestedTypeSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $a, \_PhpScopere8e811afab72\PHPStan\Type\Type $b) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if (!$a instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType || !$b instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $a->isSuperTypeOf($b);
        }
        if ($a instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType || $b instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType) {
            return $a->isSuperTypeOf($b);
        }
        if ($a->isExplicitMixed()) {
            if ($b->isExplicitMixed()) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType || $otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType($this->keyType, $this->itemType), new \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType([new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\Traversable::class), $this])]));
        }
        if ($otherType instanceof self) {
            $limit = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        } else {
            $limit = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType && $otherType->isEmpty()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return $limit->and($otherType->isIterable(), $otherType->getIterableValueType()->isSuperTypeOf($this->itemType), $otherType->getIterableKeyType()->isSuperTypeOf($this->keyType));
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        return $this->keyType->equals($type->keyType) && $this->itemType->equals($type->itemType);
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        $isMixedKeyType = $this->keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$this->keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
        $isMixedItemType = $this->itemType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$this->itemType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
        if ($isMixedKeyType) {
            if ($isMixedItemType) {
                return 'iterable';
            }
            return \sprintf('iterable<%s>', $this->itemType->describe($level));
        }
        return \sprintf('iterable<%s, %s>', $this->keyType->describe($level), $this->itemType->describe($level));
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($this->getIterableKeyType()->isSuperTypeOf($offsetType)->no()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType($this->keyType, $this->getItemType());
    }
    public function isIterable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function isIterableAtLeastOnce() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getIterableKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->keyType;
    }
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->getItemType();
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function inferTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $receivedType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if (!$receivedType->isIterable()->yes()) {
            return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $keyTypeMap = $this->getIterableKeyType()->inferTemplateTypes($receivedType->getIterableKeyType());
        $valueTypeMap = $this->getIterableValueType()->inferTemplateTypes($receivedType->getIterableValueType());
        return $keyTypeMap->union($valueTypeMap);
    }
    public function getReferencedTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return \array_merge($this->getIterableKeyType()->getReferencedTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()), $this->getIterableValueType()->getReferencedTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()));
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $keyType = $cb($this->keyType);
        $itemType = $cb($this->itemType);
        if ($keyType !== $this->keyType || $itemType !== $this->itemType) {
            return new self($keyType, $itemType);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['keyType'], $properties['itemType']);
    }
}
