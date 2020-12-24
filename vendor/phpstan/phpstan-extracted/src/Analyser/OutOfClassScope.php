<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Analyser;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
class OutOfClassScope implements \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function isInClass() : bool
    {
        return \false;
    }
    public function getClassReflection() : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return null;
    }
    public function canAccessProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool
    {
        return $propertyReflection->isPublic();
    }
    public function canCallMethod(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->isPublic();
    }
    public function canAccessConstant(\_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection $constantReflection) : bool
    {
        return $constantReflection->isPublic();
    }
}
