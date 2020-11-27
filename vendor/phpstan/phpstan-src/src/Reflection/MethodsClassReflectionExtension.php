<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

interface MethodsClassReflectionExtension
{
    public function hasMethod(\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool;
    public function getMethod(\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \PHPStan\Reflection\MethodReflection;
}
