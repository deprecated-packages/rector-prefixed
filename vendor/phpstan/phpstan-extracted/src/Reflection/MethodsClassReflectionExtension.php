<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

interface MethodsClassReflectionExtension
{
    public function hasMethod(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool;
    public function getMethod(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
}
