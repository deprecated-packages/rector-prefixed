<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Traits;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyMethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyPropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
trait MaybeObjectTypeTrait
{
    public function canAccessProperties() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function hasProperty(string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyPropertyReflection();
    }
    public function canCallMethods() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function hasMethod(string $methodName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyMethodReflection($methodName);
    }
    public function canAccessConstants() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function hasConstant(string $constantName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getConstant(string $constantName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyConstantReflection($constantName);
    }
    public function isCloneable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
}
