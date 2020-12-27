<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\Dummy\DummyConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\Dummy\DummyMethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\Dummy\DummyPropertyReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\ArrayType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
trait ObjectTypeTrait
{
    use MaybeCallableTypeTrait;
    use MaybeIterableTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use TruthyBooleanTypeTrait;
    public function canAccessProperties() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function hasProperty(string $propertyName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        return new \RectorPrefix20201227\PHPStan\Reflection\Dummy\DummyPropertyReflection();
    }
    public function canCallMethods() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
    {
        return new \RectorPrefix20201227\PHPStan\Reflection\Dummy\DummyMethodReflection($methodName);
    }
    public function canAccessConstants() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getConstant(string $constantName) : \RectorPrefix20201227\PHPStan\Reflection\ConstantReflection
    {
        return new \RectorPrefix20201227\PHPStan\Reflection\Dummy\DummyConstantReflection($constantName);
    }
    public function isCloneable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function isArray() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\StringType();
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
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
    }
}
