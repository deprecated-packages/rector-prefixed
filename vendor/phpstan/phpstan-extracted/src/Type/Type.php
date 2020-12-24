<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ConstantReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeReference;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance;
interface Type
{
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array;
    public function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function isSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function equals(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool;
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string;
    public function canAccessProperties() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function hasProperty(string $propertyName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function getProperty(string $propertyName, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
    public function canCallMethods() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function hasMethod(string $methodName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function getMethod(string $methodName, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
    public function canAccessConstants() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function hasConstant(string $constantName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function getConstant(string $constantName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ConstantReflection;
    public function isIterable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function isIterableAtLeastOnce() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function getIterableKeyType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function getIterableValueType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function isArray() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function isOffsetAccessible() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function hasOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function getOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function setOffsetValueType(?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $valueType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function isCallable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array;
    public function isCloneable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function toBoolean() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
    public function toNumber() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function toInteger() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function toFloat() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function toString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function toArray() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function isSmallerThan(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function isNumericString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    /**
     * Infers template types
     *
     * Infers the real Type of the TemplateTypes found in $this, based on
     * the received Type.
     */
    public function inferTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $receivedType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
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
    public function getReferencedTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array;
    /**
     * Traverses inner types
     *
     * Returns a new instance with all inner types mapped through $cb. Might
     * return the same instance if inner types did not change.
     *
     * @param callable(Type):Type $cb
     */
    public function traverse(callable $cb) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self;
}
