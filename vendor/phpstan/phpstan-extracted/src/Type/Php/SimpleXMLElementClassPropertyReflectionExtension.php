<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\SimpleXMLElementProperty;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
class SimpleXMLElementClassPropertyReflectionExtension implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    public function hasProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getName() === 'SimpleXMLElement' || $classReflection->isSubclassOf('SimpleXMLElement');
    }
    public function getProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\SimpleXMLElementProperty($classReflection, new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($classReflection->getName()));
    }
}
