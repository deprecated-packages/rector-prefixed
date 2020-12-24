<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\SimpleXMLElementProperty;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
class SimpleXMLElementClassPropertyReflectionExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getName() === 'SimpleXMLElement' || $classReflection->isSubclassOf('SimpleXMLElement');
    }
    public function getProperty(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\SimpleXMLElementProperty($classReflection, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($classReflection->getName()));
    }
}
