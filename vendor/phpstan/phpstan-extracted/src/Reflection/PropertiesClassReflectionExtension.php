<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

interface PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool;
    public function getProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
}
