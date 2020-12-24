<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

interface PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool;
    public function getProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection;
}
