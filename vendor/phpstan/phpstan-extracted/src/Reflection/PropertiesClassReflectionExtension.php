<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

interface PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool;
    public function getProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
}
