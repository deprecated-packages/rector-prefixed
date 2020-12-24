<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
interface ReadWritePropertiesExtension
{
    public function isAlwaysRead(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isAlwaysWritten(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isInitialized(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
}
