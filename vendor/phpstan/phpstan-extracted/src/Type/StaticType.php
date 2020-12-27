<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class StaticType implements \PHPStan\Type\TypeWithClassName
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
    public function getAncestorWithClassName(string $className) : ?\PHPStan\Type\ObjectType
    {
        return $this->getStaticObjectType()->getAncestorWithClassName($className);
    }
    public function getStaticObjectType() : \PHPStan\Type\ObjectType
    {
        if ($this->staticObjectType === null) {
            $this->staticObjectType = new \PHPStan\Type\ObjectType($this->baseClass);
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
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if (!$type instanceof static) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return $this->getStaticObjectType()->accepts($type->getStaticObjectType(), $strictTypes);
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->getStaticObjectType()->isSuperTypeOf($type);
        }
        if ($type instanceof \PHPStan\Type\ObjectWithoutClassType) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\ObjectType) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe()->and($this->getStaticObjectType()->isSuperTypeOf($type));
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        if (\get_class($type) !== static::class) {
            return \false;
        }
        /** @var StaticType $type */
        $type = $type;
        return $this->getStaticObjectType()->equals($type->getStaticObjectType());
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('static(%s)', $this->getClassName());
    }
    public function canAccessProperties() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canAccessProperties();
    }
    public function hasProperty(string $propertyName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasProperty($propertyName);
    }
    public function getProperty(string $propertyName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        return $this->getStaticObjectType()->getProperty($propertyName, $scope);
    }
    public function canCallMethods() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canCallMethods();
    }
    public function hasMethod(string $methodName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasMethod($methodName);
    }
    public function getMethod(string $methodName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
    {
        return $this->getStaticObjectType()->getMethod($methodName, $scope);
    }
    public function canAccessConstants() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canAccessConstants();
    }
    public function hasConstant(string $constantName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasConstant($constantName);
    }
    public function getConstant(string $constantName) : \RectorPrefix20201227\PHPStan\Reflection\ConstantReflection
    {
        return $this->getStaticObjectType()->getConstant($constantName);
    }
    public function changeBaseClass(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection) : self
    {
        return new self($classReflection->getName());
    }
    public function isIterable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isIterable();
    }
    public function isIterableAtLeastOnce() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isIterableAtLeastOnce();
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getIterableKeyType();
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getIterableValueType();
    }
    public function isOffsetAccessible() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isOffsetAccessible();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasOffsetValueType($offsetType);
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getOffsetValueType($offsetType);
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->setOffsetValueType($offsetType, $valueType);
    }
    public function isCallable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isCallable();
    }
    public function isArray() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isArray();
    }
    public function isNumericString() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isNumericString();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return $this->getStaticObjectType()->getCallableParametersAcceptors($scope);
    }
    public function isCloneable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->toString();
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
        return $this->getStaticObjectType()->toArray();
    }
    public function toBoolean() : \PHPStan\Type\BooleanType
    {
        return $this->getStaticObjectType()->toBoolean();
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['baseClass']);
    }
}
