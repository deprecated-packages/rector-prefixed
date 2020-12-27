<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\Php\SimpleXMLElementProperty;
use RectorPrefix20201227\PHPStan\Reflection\PropertiesClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\ObjectType;
class SimpleXMLElementClassPropertyReflectionExtension implements \RectorPrefix20201227\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    public function hasProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getName() === 'SimpleXMLElement' || $classReflection->isSubclassOf('SimpleXMLElement');
    }
    public function getProperty(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        return new \RectorPrefix20201227\PHPStan\Reflection\Php\SimpleXMLElementProperty($classReflection, new \PHPStan\Type\ObjectType($classReflection->getName()));
    }
}
