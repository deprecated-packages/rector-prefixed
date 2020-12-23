<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

interface PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool;
    public function getProperty(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
}
