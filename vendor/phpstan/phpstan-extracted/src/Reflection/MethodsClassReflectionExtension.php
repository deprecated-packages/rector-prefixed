<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

interface MethodsClassReflectionExtension
{
    public function hasMethod(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool;
    public function getMethod(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
}
