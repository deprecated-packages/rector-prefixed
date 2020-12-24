<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeReference;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance;
interface Type
{
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array;
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool;
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string;
    public function canAccessProperties() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function hasProperty(string $propertyName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getProperty(string $propertyName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
    public function canCallMethods() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function hasMethod(string $methodName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getMethod(string $methodName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
    public function canAccessConstants() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function hasConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
    public function isIterable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function isIterableAtLeastOnce() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getIterableKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array;
    public function isCloneable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType;
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function isSmallerThan(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    /**
     * Infers template types
     *
     * Infers the real Type of the TemplateTypes found in $this, based on
     * the received Type.
     */
    public function inferTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $receivedType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
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
    public function getReferencedTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array;
    /**
     * Traverses inner types
     *
     * Returns a new instance with all inner types mapped through $cb. Might
     * return the same instance if inner types did not change.
     *
     * @param callable(Type):Type $cb
     */
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self;
}
