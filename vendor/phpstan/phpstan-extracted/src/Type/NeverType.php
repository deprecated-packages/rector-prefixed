<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\FalseyBooleanTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class NeverType implements \_PhpScopere8e811afab72\PHPStan\Type\CompoundType
{
    use FalseyBooleanTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var bool */
    private $isExplicit;
    public function __construct(bool $isExplicit = \false)
    {
        $this->isExplicit = $isExplicit;
    }
    public function isExplicit() : bool
    {
        return $this->isExplicit;
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
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return '*NEVER*';
    }
    public function canAccessProperties() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasProperty(string $propertyName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getProperty(string $propertyName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getMethod(string $methodName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
    }
    public function canAccessConstants() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection
    {
        throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
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
        return new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
    }
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
    }
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
    }
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function isCloneable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['isExplicit']);
    }
}
