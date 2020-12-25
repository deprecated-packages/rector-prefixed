<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateMixedType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class StrictMixedType implements \PHPStan\Type\CompoundType
{
    use UndecidedComparisonCompoundTypeTrait;
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createFromBoolean($acceptingType instanceof \PHPStan\Type\MixedType && !$acceptingType instanceof \PHPStan\Type\Generic\TemplateMixedType);
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createFromBoolean($type instanceof self);
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createFromBoolean($otherType instanceof self);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'mixed';
    }
    public function canAccessProperties() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasProperty(string $propertyName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getProperty(string $propertyName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\PropertyReflection
    {
        throw new \PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasMethod(string $methodName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getMethod(string $methodName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\MethodReflection
    {
        throw new \PHPStan\ShouldNotHappenException();
    }
    public function canAccessConstants() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasConstant(string $constantName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getConstant(string $constantName) : \PHPStan\Reflection\ConstantReflection
    {
        throw new \PHPStan\ShouldNotHappenException();
    }
    public function isIterable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return $this;
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function isCallable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getCallableParametersAcceptors(\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [];
    }
    public function isCloneable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function toBoolean() : \PHPStan\Type\BooleanType
    {
        return new \PHPStan\Type\BooleanType();
    }
    public function toNumber() : \PHPStan\Type\Type
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
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [];
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
        return new self();
    }
}
