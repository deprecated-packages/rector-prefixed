<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeReference;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance;
interface Type
{
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array;
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool;
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string;
    public function canAccessProperties() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function hasProperty(string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function getProperty(string $propertyName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
    public function canCallMethods() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function hasMethod(string $methodName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function getMethod(string $methodName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
    public function canAccessConstants() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function hasConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function getConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection;
    public function isIterable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function isIterableAtLeastOnce() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function getIterableKeyType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function getIterableValueType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function isArray() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function isOffsetAccessible() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function hasOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function getOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function setOffsetValueType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $valueType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function isCallable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array;
    public function isCloneable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function toBoolean() : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
    public function toNumber() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function toInteger() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function toFloat() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function toString() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function toArray() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function isSmallerThan(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function isNumericString() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    /**
     * Infers template types
     *
     * Infers the real Type of the TemplateTypes found in $this, based on
     * the received Type.
     */
    public function inferTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $receivedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
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
    public function getReferencedTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array;
    /**
     * Traverses inner types
     *
     * Returns a new instance with all inner types mapped through $cb. Might
     * return the same instance if inner types did not change.
     *
     * @param callable(Type):Type $cb
     */
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self;
}
