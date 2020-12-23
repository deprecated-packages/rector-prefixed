<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\SimpleXMLElementProperty;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
class SimpleXMLElementClassPropertyReflectionExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getName() === 'SimpleXMLElement' || $classReflection->isSubclassOf('SimpleXMLElement');
    }
    public function getProperty(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\SimpleXMLElementProperty($classReflection, new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($classReflection->getName()));
    }
}
