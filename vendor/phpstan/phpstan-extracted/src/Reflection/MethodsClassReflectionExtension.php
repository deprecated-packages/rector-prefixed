<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

interface MethodsClassReflectionExtension
{
    public function hasMethod(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool;
    public function getMethod(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
}
