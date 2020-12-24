<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeReference;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance;
interface Type
{
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array;
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool;
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string;
    public function canAccessProperties() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function hasProperty(string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getProperty(string $propertyName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
    public function canCallMethods() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function hasMethod(string $methodName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getMethod(string $methodName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
    public function canAccessConstants() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function hasConstant(string $constantName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getConstant(string $constantName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection;
    public function isIterable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function isIterableAtLeastOnce() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getIterableKeyType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function getIterableValueType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function isArray() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function isOffsetAccessible() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function hasOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function isCallable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array;
    public function isCloneable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function toBoolean() : \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function toArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function isSmallerThan(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function isNumericString() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    /**
     * Infers template types
     *
     * Infers the real Type of the TemplateTypes found in $this, based on
     * the received Type.
     */
    public function inferTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $receivedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
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
    public function getReferencedTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array;
    /**
     * Traverses inner types
     *
     * Returns a new instance with all inner types mapped through $cb. Might
     * return the same instance if inner types did not change.
     *
     * @param callable(Type):Type $cb
     */
    public function traverse(callable $cb) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self;
}
