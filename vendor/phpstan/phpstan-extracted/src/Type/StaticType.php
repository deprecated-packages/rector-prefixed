<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class StaticType implements \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName
{
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    /** @var string */
    private $baseClass;
    /** @var \PHPStan\Type\ObjectType|null */
    private $staticObjectType = null;
    public function __construct(string $baseClass)
    {
        $this->baseClass = $baseClass;
    }
    public function getClassName() : string
    {
        return $this->baseClass;
    }
    public function getAncestorWithClassName(string $className) : ?\_PhpScopere8e811afab72\PHPStan\Type\ObjectType
    {
        return $this->getStaticObjectType()->getAncestorWithClassName($className);
    }
    public function getStaticObjectType() : \_PhpScopere8e811afab72\PHPStan\Type\ObjectType
    {
        if ($this->staticObjectType === null) {
            $this->staticObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($this->baseClass);
        }
        return $this->staticObjectType;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return $this->getStaticObjectType()->getReferencedClasses();
    }
    public function getBaseClass() : string
    {
        return $this->baseClass;
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if (!$type instanceof static) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return $this->getStaticObjectType()->accepts($type->getStaticObjectType(), $strictTypes);
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->getStaticObjectType()->isSuperTypeOf($type);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe()->and($this->getStaticObjectType()->isSuperTypeOf($type));
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (\get_class($type) !== static::class) {
            return \false;
        }
        /** @var StaticType $type */
        $type = $type;
        return $this->getStaticObjectType()->equals($type->getStaticObjectType());
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('static(%s)', $this->getClassName());
    }
    public function canAccessProperties() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canAccessProperties();
    }
    public function hasProperty(string $propertyName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasProperty($propertyName);
    }
    public function getProperty(string $propertyName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        return $this->getStaticObjectType()->getProperty($propertyName, $scope);
    }
    public function canCallMethods() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canCallMethods();
    }
    public function hasMethod(string $methodName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasMethod($methodName);
    }
    public function getMethod(string $methodName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        return $this->getStaticObjectType()->getMethod($methodName, $scope);
    }
    public function canAccessConstants() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canAccessConstants();
    }
    public function hasConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasConstant($constantName);
    }
    public function getConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection
    {
        return $this->getStaticObjectType()->getConstant($constantName);
    }
    public function changeBaseClass(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection) : self
    {
        return new self($classReflection->getName());
    }
    public function isIterable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isIterable();
    }
    public function isIterableAtLeastOnce() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isIterableAtLeastOnce();
    }
    public function getIterableKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getIterableKeyType();
    }
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getIterableValueType();
    }
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isOffsetAccessible();
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasOffsetValueType($offsetType);
    }
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getOffsetValueType($offsetType);
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->setOffsetValueType($offsetType, $valueType);
    }
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isCallable();
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isArray();
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isNumericString();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return $this->getStaticObjectType()->getCallableParametersAcceptors($scope);
    }
    public function isCloneable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->toString();
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
        return $this->getStaticObjectType()->toArray();
    }
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType
    {
        return $this->getStaticObjectType()->toBoolean();
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['baseClass']);
    }
}
