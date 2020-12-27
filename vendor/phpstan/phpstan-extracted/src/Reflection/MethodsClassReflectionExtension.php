<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

interface MethodsClassReflectionExtension
{
    public function hasMethod(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool;
    public function getMethod(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
}
