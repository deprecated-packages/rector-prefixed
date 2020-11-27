<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

interface PropertiesClassReflectionExtension
{
    public function hasProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool;
    public function getProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \PHPStan\Reflection\PropertyReflection;
}
