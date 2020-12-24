<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

interface ClassMemberAccessAnswerer
{
    public function isInClass() : bool;
    public function getClassReflection() : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
    public function canAccessProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool;
    public function canCallMethod(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function canAccessConstant(\_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection $constantReflection) : bool;
}
