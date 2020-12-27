<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

interface PropertiesClassReflectionExtension
{
    public function hasProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool;
    public function getProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
}
