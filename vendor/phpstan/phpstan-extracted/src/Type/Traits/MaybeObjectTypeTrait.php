<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\Dummy\DummyConstantReflection;
use PHPStan\Reflection\Dummy\DummyMethodReflection;
use PHPStan\Reflection\Dummy\DummyPropertyReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
trait MaybeObjectTypeTrait
{
    public function canAccessProperties() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function hasProperty(string $propertyName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\PropertyReflection
    {
        return new \PHPStan\Reflection\Dummy\DummyPropertyReflection();
    }
    public function canCallMethods() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function hasMethod(string $methodName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\MethodReflection
    {
        return new \PHPStan\Reflection\Dummy\DummyMethodReflection($methodName);
    }
    public function canAccessConstants() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function hasConstant(string $constantName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getConstant(string $constantName) : \PHPStan\Reflection\ConstantReflection
    {
        return new \PHPStan\Reflection\Dummy\DummyConstantReflection($constantName);
    }
    public function isCloneable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
}
