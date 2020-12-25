<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\TrivialParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\TemplateMixedType;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Traits\MaybeCallableTypeTrait;
use PHPStan\Type\Traits\NonObjectTypeTrait;
use PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ArrayType implements \PHPStan\Type\Type
{
    use MaybeCallableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    /** @var \PHPStan\Type\Type */
    private $keyType;
    /** @var \PHPStan\Type\Type */
    private $itemType;
    public function __construct(\PHPStan\Type\Type $keyType, \PHPStan\Type\Type $itemType)
    {
        if ($keyType->describe(\PHPStan\Type\VerbosityLevel::value()) === '(int|string)') {
            $keyType = new \PHPStan\Type\MixedType();
        }
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
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            $result = \PHPStan\TrinaryLogic::createYes();
            $thisKeyType = $this->keyType;
            $itemType = $this->getItemType();
            foreach ($type->getKeyTypes() as $i => $keyType) {
                $valueType = $type->getValueTypes()[$i];
                $result = $result->and($thisKeyType->accepts($keyType, $strictTypes))->and($itemType->accepts($valueType, $strictTypes));
            }
            return $result;
        }
        if ($type instanceof \PHPStan\Type\ArrayType) {
            return $this->getItemType()->accepts($type->getItemType(), $strictTypes)->and($this->keyType->accepts($type->keyType, $strictTypes));
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->getItemType()->isSuperTypeOf($type->getItemType())->and($this->keyType->isSuperTypeOf($type->keyType));
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && !$type instanceof \PHPStan\Type\Constant\ConstantArrayType && $this->getItemType()->equals($type->getItemType()) && $this->keyType->equals($type->keyType);
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        $isMixedKeyType = $this->keyType instanceof \PHPStan\Type\MixedType && $this->keyType->describe(\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $isMixedItemType = $this->itemType instanceof \PHPStan\Type\MixedType && $this->itemType->describe(\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $valueHandler = function () use($level, $isMixedKeyType, $isMixedItemType) : string {
            if ($isMixedKeyType || $this->keyType instanceof \PHPStan\Type\NeverType) {
                if ($isMixedItemType || $this->itemType instanceof \PHPStan\Type\NeverType) {
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
        return new self($this->keyType, \PHPStan\Type\TypeUtils::generalizeType($this->itemType));
    }
    public function getKeysArray() : self
    {
        return new self(new \PHPStan\Type\IntegerType(), $this->keyType);
    }
    public function getValuesArray() : self
    {
        return new self(new \PHPStan\Type\IntegerType(), $this->itemType);
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
        $keyType = $this->keyType;
        if ($keyType instanceof \PHPStan\Type\MixedType && !$keyType instanceof \PHPStan\Type\Generic\TemplateMixedType) {
            return new \PHPStan\Type\BenevolentUnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]);
        }
        return $keyType;
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return $this->getItemType();
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return new \PHPStan\Type\ErrorType();
        }
        $type = $this->getItemType();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return new \PHPStan\Type\MixedType();
        }
        return $type;
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType, bool $unionValues = \true) : \PHPStan\Type\Type
    {
        if ($offsetType === null) {
            $offsetType = new \PHPStan\Type\IntegerType();
        }
        return \PHPStan\Type\TypeCombinator::intersect(new self(\PHPStan\Type\TypeCombinator::union($this->keyType, self::castToArrayKeyType($offsetType)), $unionValues ? \PHPStan\Type\TypeCombinator::union($this->itemType, $valueType) : $valueType), new \PHPStan\Type\Accessory\NonEmptyArrayType());
    }
    public function isCallable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe()->and((new \PHPStan\Type\StringType())->isSuperTypeOf($this->itemType));
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->isCallable()->no()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return [new \PHPStan\Reflection\TrivialParametersAcceptor()];
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
        return $this;
    }
    public function count() : \PHPStan\Type\Type
    {
        return \PHPStan\Type\IntegerRangeType::fromInterval(0, null);
    }
    public static function castToArrayKeyType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeTraverser::map($offsetType, static function (\PHPStan\Type\Type $offsetType, callable $traverse) : Type {
            if ($offsetType instanceof \PHPStan\Type\Generic\TemplateType) {
                return $offsetType;
            }
            if ($offsetType instanceof \PHPStan\Type\ConstantScalarType) {
                /** @var int|string $offsetValue */
                $offsetValue = \key([$offsetType->getValue() => null]);
                return \is_int($offsetValue) ? new \PHPStan\Type\Constant\ConstantIntegerType($offsetValue) : new \PHPStan\Type\Constant\ConstantStringType($offsetValue);
            }
            if ($offsetType instanceof \PHPStan\Type\IntegerType) {
                return $offsetType;
            }
            if ($offsetType instanceof \PHPStan\Type\FloatType || $offsetType instanceof \PHPStan\Type\BooleanType || $offsetType->isNumericString()->yes()) {
                return new \PHPStan\Type\IntegerType();
            }
            if ($offsetType instanceof \PHPStan\Type\StringType) {
                return $offsetType;
            }
            if ($offsetType instanceof \PHPStan\Type\UnionType || $offsetType instanceof \PHPStan\Type\IntersectionType) {
                return $traverse($offsetType);
            }
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]);
        });
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \PHPStan\Type\UnionType || $receivedType instanceof \PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \PHPStan\Type\Constant\ConstantArrayType && \count($receivedType->getKeyTypes()) === 0) {
            $keyType = $this->getKeyType();
            $typeMap = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
            if ($keyType instanceof \PHPStan\Type\Generic\TemplateType) {
                $typeMap = new \PHPStan\Type\Generic\TemplateTypeMap([$keyType->getName() => $keyType->getBound()]);
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \PHPStan\Type\Generic\TemplateType) {
                $typeMap = $typeMap->union(new \PHPStan\Type\Generic\TemplateTypeMap([$itemType->getName() => $itemType->getBound()]));
            }
            return $typeMap;
        }
        if ($receivedType instanceof \PHPStan\Type\ArrayType && !$this->getKeyType()->isSuperTypeOf($receivedType->getKeyType())->no() && !$this->getItemType()->isSuperTypeOf($receivedType->getItemType())->no()) {
            $keyTypeMap = $this->getKeyType()->inferTemplateTypes($receivedType->getKeyType());
            $itemTypeMap = $this->getItemType()->inferTemplateTypes($receivedType->getItemType());
            return $keyTypeMap->union($itemTypeMap);
        }
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $keyVariance = $positionVariance;
        $itemVariance = $positionVariance;
        if (!$positionVariance->contravariant()) {
            $keyType = $this->getKeyType();
            if ($keyType instanceof \PHPStan\Type\Generic\TemplateType) {
                $keyVariance = $keyType->getVariance();
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \PHPStan\Type\Generic\TemplateType) {
                $itemVariance = $itemType->getVariance();
            }
        }
        return \array_merge($this->getKeyType()->getReferencedTemplateTypes($keyVariance), $this->getItemType()->getReferencedTemplateTypes($itemVariance));
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
