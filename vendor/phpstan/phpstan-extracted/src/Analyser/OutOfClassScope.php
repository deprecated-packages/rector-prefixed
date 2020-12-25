<?php

declare (strict_types=1);
namespace PHPStan\Analyser;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
class OutOfClassScope implements \PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function isInClass() : bool
    {
        return \false;
    }
    public function getClassReflection() : ?\PHPStan\Reflection\ClassReflection
    {
        return null;
    }
    public function canAccessProperty(\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool
    {
        return $propertyReflection->isPublic();
    }
    public function canCallMethod(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->isPublic();
    }
    public function canAccessConstant(\PHPStan\Reflection\ConstantReflection $constantReflection) : bool
    {
        return $constantReflection->isPublic();
    }
}
