<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\SimpleXMLElementProperty;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
class SimpleXMLElementClassPropertyReflectionExtension implements \_PhpScopere8e811afab72\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getName() === 'SimpleXMLElement' || $classReflection->isSubclassOf('SimpleXMLElement');
    }
    public function getProperty(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Php\SimpleXMLElementProperty($classReflection, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($classReflection->getName()));
    }
}
