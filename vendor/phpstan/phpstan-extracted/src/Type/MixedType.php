<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Dummy\DummyConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Dummy\DummyMethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Dummy\DummyPropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeIterableTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class MixedType implements \_PhpScopere8e811afab72\PHPStan\Type\CompoundType, \_PhpScopere8e811afab72\PHPStan\Type\SubtractableType
{
    use MaybeIterableTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var bool */
    private $isExplicitMixed;
    /** @var \PHPStan\Type\Type|null */
    private $subtractedType;
    public function __construct(bool $isExplicitMixed = \false, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $subtractedType = null)
    {
        if ($subtractedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->isExplicitMixed = $isExplicitMixed;
        $this->subtractedType = $subtractedType;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function isSuperTypeOfMixed(\_PhpScopere8e811afab72\PHPStan\Type\MixedType $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType === null) {
            if ($this->isExplicitMixed) {
                if ($type->isExplicitMixed) {
                    return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
                }
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($type->subtractedType === null) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
        if ($isSuperType->yes()) {
            if ($this->isExplicitMixed) {
                if ($type->isExplicitMixed) {
                    return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
                }
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType === null || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof self) {
            if ($type->subtractedType === null) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
            }
            $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
            if ($isSuperType->yes()) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->subtractedType->isSuperTypeOf($type)->negate();
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType !== null && $this->subtractedType->isCallable()->yes()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if ($this->subtractedType === null) {
            if ($type->subtractedType === null) {
                return \true;
            }
            return \false;
        }
        if ($type->subtractedType === null) {
            return \false;
        }
        return $this->subtractedType->equals($type->subtractedType);
    }
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self && !$otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($otherType);
            if ($isSuperType->yes()) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
            }
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $isSuperType = $this->isSuperTypeOf($acceptingType);
        if ($isSuperType->no()) {
            return $isSuperType;
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function canAccessProperties() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasProperty(string $propertyName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function getProperty(string $propertyName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Dummy\DummyPropertyReflection();
    }
    public function canCallMethods() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function getMethod(string $methodName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Dummy\DummyMethodReflection($methodName);
    }
    public function canAccessConstants() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function getConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection
    {
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Dummy\DummyConstantReflection($constantName);
    }
    public function isCloneable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'mixed';
        }, static function () : string {
            return 'mixed';
        }, function () use($level) : string {
            $description = 'mixed';
            if ($this->subtractedType !== null) {
                $description .= \sprintf('~%s', $this->subtractedType->describe($level));
            }
            return $description;
        }, function () use($level) : string {
            $description = 'mixed';
            if ($this->subtractedType !== null) {
                $description .= \sprintf('~%s', $this->subtractedType->describe($level));
            }
            if ($this->isExplicitMixed) {
                $description .= '=explicit';
            } else {
                $description .= '=implicit';
            }
            return $description;
        });
    }
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType
    {
        if ($this->subtractedType !== null && \_PhpScopere8e811afab72\PHPStan\Type\StaticTypeFactory::falsey()->equals($this->subtractedType)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([$this->toInteger(), $this->toFloat()]);
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\FloatType();
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
    }
    public function isExplicitMixed() : bool
    {
        return $this->isExplicitMixed;
    }
    public function subtract(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($type instanceof self && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
        }
        if ($this->subtractedType !== null) {
            $type = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return new self($this->isExplicitMixed, $type);
    }
    public function getTypeWithoutSubtractedType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($this->isExplicitMixed);
    }
    public function changeSubtractedType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $subtractedType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($this->isExplicitMixed, $subtractedType);
    }
    public function getSubtractedType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['isExplicitMixed'], $properties['subtractedType'] ?? null);
    }
}
