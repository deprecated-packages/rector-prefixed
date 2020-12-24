<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Traits;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
trait NonObjectTypeTrait
{
    public function canAccessProperties() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasProperty(string $propertyName) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getProperty(string $propertyName, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection
    {
        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasMethod(string $methodName) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getMethod(string $methodName, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
    }
    public function canAccessConstants() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasConstant(string $constantName) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getConstant(string $constantName) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ConstantReflection
    {
        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
    }
    public function isCloneable() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
}
