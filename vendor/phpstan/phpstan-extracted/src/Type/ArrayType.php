<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ArrayType implements \_PhpScopere8e811afab72\PHPStan\Type\Type
{
    use MaybeCallableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    /** @var \PHPStan\Type\Type */
    private $keyType;
    /** @var \PHPStan\Type\Type */
    private $itemType;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Type $keyType, \_PhpScopere8e811afab72\PHPStan\Type\Type $itemType)
    {
        if ($keyType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()) === '(int|string)') {
            $keyType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
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
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            $result = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
            $thisKeyType = $this->keyType;
            $itemType = $this->getItemType();
            foreach ($type->getKeyTypes() as $i => $keyType) {
                $valueType = $type->getValueTypes()[$i];
                $result = $result->and($thisKeyType->accepts($keyType, $strictTypes))->and($itemType->accepts($valueType, $strictTypes));
            }
            return $result;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return $this->getItemType()->accepts($type->getItemType(), $strictTypes)->and($this->keyType->accepts($type->keyType, $strictTypes));
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->getItemType()->isSuperTypeOf($type->getItemType())->and($this->keyType->isSuperTypeOf($type->keyType));
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType && $this->getItemType()->equals($type->getItemType()) && $this->keyType->equals($type->keyType);
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        $isMixedKeyType = $this->keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && $this->keyType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $isMixedItemType = $this->itemType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && $this->itemType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $valueHandler = function () use($level, $isMixedKeyType, $isMixedItemType) : string {
            if ($isMixedKeyType || $this->keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
                if ($isMixedItemType || $this->itemType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
                    return 'array';
                }
                return \sprintf('array<%s>', $this->itemType->describe($level));
            }
            return \sprintf('array<%s, %s>', $this->keyType->describe($level), $this->itemType->describe($level));
        };
        return $level->handle($valueHandler, $valueHandler, function () use($level, $isMixedKeyType, $isMixedItemType) : string {
            if ($isMixedKeyType) {
                if ($isMixedItemType) {
                    return 'array';
                }
                return \sprintf('array<%s>', $this->itemType->describe($level));
            }
            return \sprintf('array<%s, %s>', $this->keyType->describe($level), $this->itemType->describe($level));
        });
    }
    public function generalizeValues() : self
    {
        return new self($this->keyType, \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::generalizeType($this->itemType));
    }
    public function getKeysArray() : self
    {
        return new self(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), $this->keyType);
    }
    public function getValuesArray() : self
    {
        return new self(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), $this->itemType);
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
        $keyType = $this->keyType;
        if ($keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType([new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType()]);
        }
        return $keyType;
    }
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->getItemType();
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        $type = $this->getItemType();
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return $type;
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType, bool $unionValues = \true) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($offsetType === null) {
            $offsetType = new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::intersect(new self(\_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($this->keyType, self::castToArrayKeyType($offsetType)), $unionValues ? \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($this->itemType, $valueType) : $valueType), new \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType());
    }
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe()->and((new \_PhpScopere8e811afab72\PHPStan\Type\StringType())->isSuperTypeOf($this->itemType));
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->isCallable()->no()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
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
        return $this;
    }
    public function count() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType::fromInterval(0, null);
    }
    public static function castToArrayKeyType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeTraverser::map($offsetType, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, callable $traverse) : Type {
            if ($offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantScalarType) {
                /** @var int|string $offsetValue */
                $offsetValue = \key([$offsetType->getValue() => null]);
                return \is_int($offsetValue) ? new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType($offsetValue) : new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType($offsetValue);
            }
            if ($offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\FloatType || $offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\BooleanType || $offsetType->isNumericString()->yes()) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
            }
            if ($offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
                return $traverse($offsetType);
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType()]);
        });
    }
    public function inferTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $receivedType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType && \count($receivedType->getKeyTypes()) === 0) {
            $keyType = $this->getKeyType();
            $typeMap = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
            if ($keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType) {
                $typeMap = new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap([$keyType->getName() => $keyType->getBound()]);
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType) {
                $typeMap = $typeMap->union(new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap([$itemType->getName() => $itemType->getBound()]));
            }
            return $typeMap;
        }
        if ($receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType && !$this->getKeyType()->isSuperTypeOf($receivedType->getKeyType())->no() && !$this->getItemType()->isSuperTypeOf($receivedType->getItemType())->no()) {
            $keyTypeMap = $this->getKeyType()->inferTemplateTypes($receivedType->getKeyType());
            $itemTypeMap = $this->getItemType()->inferTemplateTypes($receivedType->getItemType());
            return $keyTypeMap->union($itemTypeMap);
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $keyVariance = $positionVariance;
        $itemVariance = $positionVariance;
        if (!$positionVariance->contravariant()) {
            $keyType = $this->getKeyType();
            if ($keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType) {
                $keyVariance = $keyType->getVariance();
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType) {
                $itemVariance = $itemType->getVariance();
            }
        }
        return \array_merge($this->getKeyType()->getReferencedTemplateTypes($keyVariance), $this->getItemType()->getReferencedTemplateTypes($itemVariance));
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
