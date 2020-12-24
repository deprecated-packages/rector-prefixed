<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

interface PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool;
    public function getProperty(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
}
