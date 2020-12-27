<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\SimpleXMLElementProperty;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\ObjectType;
class SimpleXMLElementClassPropertyReflectionExtension implements \PHPStan\Reflection\PropertiesClassReflectionExtension
{
    public function hasProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getName() === 'SimpleXMLElement' || $classReflection->isSubclassOf('SimpleXMLElement');
    }
    public function getProperty(\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \PHPStan\Reflection\PropertyReflection
    {
        return new \PHPStan\Reflection\Php\SimpleXMLElementProperty($classReflection, new \PHPStan\Type\ObjectType($classReflection->getName()));
    }
}
