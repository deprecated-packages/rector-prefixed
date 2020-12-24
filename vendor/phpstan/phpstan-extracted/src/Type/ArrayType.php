<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ArrayType implements \_PhpScoperb75b35f52b74\PHPStan\Type\Type
{
    use MaybeCallableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    /** @var \PHPStan\Type\Type */
    private $keyType;
    /** @var \PHPStan\Type\Type */
    private $itemType;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $keyType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $itemType)
    {
        if ($keyType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()) === '(int|string)') {
            $keyType = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $this->keyType = $keyType;
        $this->itemType = $itemType;
    }
    public function getKeyType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->keyType;
    }
    public function getItemType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            $result = \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
            $thisKeyType = $this->keyType;
            $itemType = $this->getItemType();
            foreach ($type->getKeyTypes() as $i => $keyType) {
                $valueType = $type->getValueTypes()[$i];
                $result = $result->and($thisKeyType->accepts($keyType, $strictTypes))->and($itemType->accepts($valueType, $strictTypes));
            }
            return $result;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return $this->getItemType()->accepts($type->getItemType(), $strictTypes)->and($this->keyType->accepts($type->keyType, $strictTypes));
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->getItemType()->isSuperTypeOf($type->getItemType())->and($this->keyType->isSuperTypeOf($type->keyType));
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType && $this->getItemType()->equals($type->getItemType()) && $this->keyType->equals($type->keyType);
    }
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        $isMixedKeyType = $this->keyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType && $this->keyType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $isMixedItemType = $this->itemType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType && $this->itemType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $valueHandler = function () use($level, $isMixedKeyType, $isMixedItemType) : string {
            if ($isMixedKeyType || $this->keyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
                if ($isMixedItemType || $this->itemType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
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
        return new self($this->keyType, \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::generalizeType($this->itemType));
    }
    public function getKeysArray() : self
    {
        return new self(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), $this->keyType);
    }
    public function getValuesArray() : self
    {
        return new self(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), $this->itemType);
    }
    public function isIterable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function isIterableAtLeastOnce() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getIterableKeyType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $keyType = $this->keyType;
        if ($keyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType && !$keyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType()]);
        }
        return $keyType;
    }
    public function getIterableValueType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->getItemType();
    }
    public function isArray() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function isNumericString() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function isOffsetAccessible() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        $type = $this->getItemType();
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return $type;
    }
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType, bool $unionValues = \true) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($offsetType === null) {
            $offsetType = new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect(new self(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($this->keyType, self::castToArrayKeyType($offsetType)), $unionValues ? \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($this->itemType, $valueType) : $valueType), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType());
    }
    public function isCallable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe()->and((new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType())->isSuperTypeOf($this->itemType));
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->isCallable()->no()) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return [new \_PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
    public function toArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this;
    }
    public function count() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerRangeType::fromInterval(0, null);
    }
    public static function castToArrayKeyType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($offsetType, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, callable $traverse) : Type {
            if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType) {
                /** @var int|string $offsetValue */
                $offsetValue = \key([$offsetType->getValue() => null]);
                return \is_int($offsetValue) ? new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType($offsetValue) : new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($offsetValue);
            }
            if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType || $offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType || $offsetType->isNumericString()->yes()) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType();
            }
            if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
                return $traverse($offsetType);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType()]);
        });
    }
    public function inferTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $receivedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType && \count($receivedType->getKeyTypes()) === 0) {
            $keyType = $this->getKeyType();
            $typeMap = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
            if ($keyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                $typeMap = new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap([$keyType->getName() => $keyType->getBound()]);
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                $typeMap = $typeMap->union(new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap([$itemType->getName() => $itemType->getBound()]));
            }
            return $typeMap;
        }
        if ($receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType && !$this->getKeyType()->isSuperTypeOf($receivedType->getKeyType())->no() && !$this->getItemType()->isSuperTypeOf($receivedType->getItemType())->no()) {
            $keyTypeMap = $this->getKeyType()->inferTemplateTypes($receivedType->getKeyType());
            $itemTypeMap = $this->getItemType()->inferTemplateTypes($receivedType->getItemType());
            return $keyTypeMap->union($itemTypeMap);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $keyVariance = $positionVariance;
        $itemVariance = $positionVariance;
        if (!$positionVariance->contravariant()) {
            $keyType = $this->getKeyType();
            if ($keyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                $keyVariance = $keyType->getVariance();
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                $itemVariance = $itemType->getVariance();
            }
        }
        return \array_merge($this->getKeyType()->getReferencedTemplateTypes($keyVariance), $this->getItemType()->getReferencedTemplateTypes($itemVariance));
    }
    public function traverse(callable $cb) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($properties['keyType'], $properties['itemType']);
    }
}
