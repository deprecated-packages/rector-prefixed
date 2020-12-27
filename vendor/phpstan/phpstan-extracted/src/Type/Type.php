<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeReference;
use PHPStan\Type\Generic\TemplateTypeVariance;
interface Type
{
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array;
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function equals(\PHPStan\Type\Type $type) : bool;
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string;
    public function canAccessProperties() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function hasProperty(string $propertyName) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getProperty(string $propertyName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
    public function canCallMethods() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function hasMethod(string $methodName) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getMethod(string $methodName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
    public function canAccessConstants() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function hasConstant(string $constantName) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getConstant(string $constantName) : \RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
    public function isIterable() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function isIterableAtLeastOnce() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getIterableKeyType() : \PHPStan\Type\Type;
    public function getIterableValueType() : \PHPStan\Type\Type;
    public function isArray() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function isOffsetAccessible() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type;
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type;
    public function isCallable() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array;
    public function isCloneable() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function toBoolean() : \PHPStan\Type\BooleanType;
    public function toNumber() : \PHPStan\Type\Type;
    public function toInteger() : \PHPStan\Type\Type;
    public function toFloat() : \PHPStan\Type\Type;
    public function toString() : \PHPStan\Type\Type;
    public function toArray() : \PHPStan\Type\Type;
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function isNumericString() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    /**
     * Infers template types
     *
     * Infers the real Type of the TemplateTypes found in $this, based on
     * the received Type.
     */
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap;
    /**
     * Returns the template types referenced by this Type, recursively
     *
     * The return value is a list of TemplateTypeReferences, who contain the
     * referenced template type as well as the variance position in which it was
     * found.
     *
     * For example, calling this on array<Foo<T>,Bar> (with T a template type)
     * will return one TemplateTypeReference for the type T.
     *
     * @param TemplateTypeVariance $positionVariance The variance position in
     *                                               which the receiver type was
     *                                               found.
     *
     * @return TemplateTypeReference[]
     */
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array;
    /**
     * Traverses inner types
     *
     * Returns a new instance with all inner types mapped through $cb. Might
     * return the same instance if inner types did not change.
     *
     * @param callable(Type):Type $cb
     */
    public function traverse(callable $cb) : \PHPStan\Type\Type;
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self;
}
