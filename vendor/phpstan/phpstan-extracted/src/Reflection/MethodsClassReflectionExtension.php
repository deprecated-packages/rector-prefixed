<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

interface MethodsClassReflectionExtension
{
    public function hasMethod(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool;
    public function getMethod(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
}
