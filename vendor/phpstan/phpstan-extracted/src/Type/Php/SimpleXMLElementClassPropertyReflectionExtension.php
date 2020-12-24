<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\SimpleXMLElementProperty;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
class SimpleXMLElementClassPropertyReflectionExtension implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getName() === 'SimpleXMLElement' || $classReflection->isSubclassOf('SimpleXMLElement');
    }
    public function getProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\SimpleXMLElementProperty($classReflection, new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($classReflection->getName()));
    }
}
