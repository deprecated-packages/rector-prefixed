<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Generic\TemplateMixedType;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Traits\MaybeCallableTypeTrait;
use PHPStan\Type\Traits\MaybeObjectTypeTrait;
use PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class IterableType implements \PHPStan\Type\CompoundType
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
    public function __construct(\PHPStan\Type\Type $keyType, \PHPStan\Type\Type $itemType)
    {
        $this->keyType = $keyType;
        $this->itemType = $itemType;
    }
    public function getKeyType() : \PHPStan\Type\Type
    {
        return $this->keyType;
    }
    public function getItemType() : \PHPStan\Type\Type
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
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\Constant\ConstantArrayType && $type->isEmpty()) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type->isIterable()->yes()) {
            return $this->getIterableValueType()->accepts($type->getIterableValueType(), $strictTypes)->and($this->getIterableKeyType()->accepts($type->getIterableKeyType(), $strictTypes));
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        return $type->isIterable()->and($this->getIterableValueType()->isSuperTypeOf($type->getIterableValueType()))->and($this->getIterableKeyType()->isSuperTypeOf($type->getIterableKeyType()));
    }
    public function isSuperTypeOfMixed(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        return $type->isIterable()->and($this->isNestedTypeSuperTypeOf($this->getIterableValueType(), $type->getIterableValueType()))->and($this->isNestedTypeSuperTypeOf($this->getIterableKeyType(), $type->getIterableKeyType()));
    }
    private function isNestedTypeSuperTypeOf(\PHPStan\Type\Type $a, \PHPStan\Type\Type $b) : \PHPStan\TrinaryLogic
    {
        if (!$a instanceof \PHPStan\Type\MixedType || !$b instanceof \PHPStan\Type\MixedType) {
            return $a->isSuperTypeOf($b);
        }
        if ($a instanceof \PHPStan\Type\Generic\TemplateMixedType || $b instanceof \PHPStan\Type\Generic\TemplateMixedType) {
            return $a->isSuperTypeOf($b);
        }
        if ($a->isExplicitMixed()) {
            if ($b->isExplicitMixed()) {
                return \PHPStan\TrinaryLogic::createYes();
            }
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\IntersectionType || $otherType instanceof \PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf(new \PHPStan\Type\UnionType([new \PHPStan\Type\ArrayType($this->keyType, $this->itemType), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\Traversable::class), $this])]));
        }
        if ($otherType instanceof self) {
            $limit = \PHPStan\TrinaryLogic::createYes();
        } else {
            $limit = \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($otherType instanceof \PHPStan\Type\Constant\ConstantArrayType && $otherType->isEmpty()) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return $limit->and($otherType->isIterable(), $otherType->getIterableValueType()->isSuperTypeOf($this->itemType), $otherType->getIterableKeyType()->isSuperTypeOf($this->keyType));
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        return $this->keyType->equals($type->keyType) && $this->itemType->equals($type->itemType);
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        $isMixedKeyType = $this->keyType instanceof \PHPStan\Type\MixedType && !$this->keyType instanceof \PHPStan\Type\Generic\TemplateType;
        $isMixedItemType = $this->itemType instanceof \PHPStan\Type\MixedType && !$this->itemType instanceof \PHPStan\Type\Generic\TemplateType;
        if ($isMixedKeyType) {
            if ($isMixedItemType) {
                return 'iterable';
            }
            return \sprintf('iterable<%s>', $this->itemType->describe($level));
        }
        return \sprintf('iterable<%s, %s>', $this->keyType->describe($level), $this->itemType->describe($level));
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        if ($this->getIterableKeyType()->isSuperTypeOf($offsetType)->no()) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toString() : \PHPStan\Type\Type
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
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ArrayType($this->keyType, $this->getItemType());
    }
    public function isIterable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return $this->keyType;
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return $this->getItemType();
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \PHPStan\Type\UnionType || $receivedType instanceof \PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if (!$receivedType->isIterable()->yes()) {
            return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $keyTypeMap = $this->getIterableKeyType()->inferTemplateTypes($receivedType->getIterableKeyType());
        $valueTypeMap = $this->getIterableValueType()->inferTemplateTypes($receivedType->getIterableValueType());
        return $keyTypeMap->union($valueTypeMap);
    }
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return \array_merge($this->getIterableKeyType()->getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()), $this->getIterableValueType()->getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()));
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
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
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['keyType'], $properties['itemType']);
    }
}
