<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Traits;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
trait NonObjectTypeTrait
{
    public function canAccessProperties() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function hasProperty(string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function getProperty(string $propertyName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
    {
        throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function hasMethod(string $methodName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function getMethod(string $methodName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
    {
        throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
    }
    public function canAccessConstants() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function hasConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function getConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection
    {
        throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
    }
    public function isCloneable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
}
