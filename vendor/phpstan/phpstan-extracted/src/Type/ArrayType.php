<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ArrayType implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
{
    use MaybeCallableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    /** @var \PHPStan\Type\Type */
    private $keyType;
    /** @var \PHPStan\Type\Type */
    private $itemType;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $keyType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $itemType)
    {
        if ($keyType->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()) === '(int|string)') {
            $keyType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        $this->keyType = $keyType;
        $this->itemType = $itemType;
    }
    public function getKeyType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->keyType;
    }
    public function getItemType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
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
    public function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType) {
            $result = \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
            $thisKeyType = $this->keyType;
            $itemType = $this->getItemType();
            foreach ($type->getKeyTypes() as $i => $keyType) {
                $valueType = $type->getValueTypes()[$i];
                $result = $result->and($thisKeyType->accepts($keyType, $strictTypes))->and($itemType->accepts($valueType, $strictTypes));
            }
            return $result;
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
            return $this->getItemType()->accepts($type->getItemType(), $strictTypes)->and($this->keyType->accepts($type->keyType, $strictTypes));
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->getItemType()->isSuperTypeOf($type->getItemType())->and($this->keyType->isSuperTypeOf($type->keyType));
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && !$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType && $this->getItemType()->equals($type->getItemType()) && $this->keyType->equals($type->keyType);
    }
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string
    {
        $isMixedKeyType = $this->keyType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType && $this->keyType->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $isMixedItemType = $this->itemType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType && $this->itemType->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $valueHandler = function () use($level, $isMixedKeyType, $isMixedItemType) : string {
            if ($isMixedKeyType || $this->keyType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType) {
                if ($isMixedItemType || $this->itemType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType) {
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
        return new self($this->keyType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::generalizeType($this->itemType));
    }
    public function getKeysArray() : self
    {
        return new self(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), $this->keyType);
    }
    public function getValuesArray() : self
    {
        return new self(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), $this->itemType);
    }
    public function isIterable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
    }
    public function isIterableAtLeastOnce() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getIterableKeyType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $keyType = $this->keyType;
        if ($keyType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType && !$keyType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateMixedType) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BenevolentUnionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType()]);
        }
        return $keyType;
    }
    public function getIterableValueType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->getItemType();
    }
    public function isArray() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
    }
    public function isNumericString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function isOffsetAccessible() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
        }
        $type = $this->getItemType();
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        return $type;
    }
    public function setOffsetValueType(?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $valueType, bool $unionValues = \true) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($offsetType === null) {
            $offsetType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType();
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::intersect(new self(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union($this->keyType, self::castToArrayKeyType($offsetType)), $unionValues ? \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union($this->itemType, $valueType) : $valueType), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\NonEmptyArrayType());
    }
    public function isCallable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe()->and((new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType())->isSuperTypeOf($this->itemType));
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->isCallable()->no()) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        return [new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function toNumber() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
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
    public function toArray() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this;
    }
    public function count() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType::fromInterval(0, null);
    }
    public static function castToArrayKeyType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser::map($offsetType, static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType, callable $traverse) : Type {
            if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType) {
                /** @var int|string $offsetValue */
                $offsetValue = \key([$offsetType->getValue() => null]);
                return \is_int($offsetValue) ? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType($offsetValue) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType($offsetValue);
            }
            if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType || $offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType || $offsetType->isNumericString()->yes()) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType();
            }
            if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType) {
                return $offsetType;
            }
            if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType || $offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType) {
                return $traverse($offsetType);
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType()]);
        });
    }
    public function inferTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $receivedType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType && \count($receivedType->getKeyTypes()) === 0) {
            $keyType = $this->getKeyType();
            $typeMap = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
            if ($keyType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                $typeMap = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap([$keyType->getName() => $keyType->getBound()]);
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                $typeMap = $typeMap->union(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap([$itemType->getName() => $itemType->getBound()]));
            }
            return $typeMap;
        }
        if ($receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType && !$this->getKeyType()->isSuperTypeOf($receivedType->getKeyType())->no() && !$this->getItemType()->isSuperTypeOf($receivedType->getItemType())->no()) {
            $keyTypeMap = $this->getKeyType()->inferTemplateTypes($receivedType->getKeyType());
            $itemTypeMap = $this->getItemType()->inferTemplateTypes($receivedType->getItemType());
            return $keyTypeMap->union($itemTypeMap);
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $keyVariance = $positionVariance;
        $itemVariance = $positionVariance;
        if (!$positionVariance->contravariant()) {
            $keyType = $this->getKeyType();
            if ($keyType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                $keyVariance = $keyType->getVariance();
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                $itemVariance = $itemType->getVariance();
            }
        }
        return \array_merge($this->getKeyType()->getReferencedTemplateTypes($keyVariance), $this->getItemType()->getReferencedTemplateTypes($itemVariance));
    }
    public function traverse(callable $cb) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
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
    public static function __set_state(array $properties) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new self($properties['keyType'], $properties['itemType']);
    }
}
