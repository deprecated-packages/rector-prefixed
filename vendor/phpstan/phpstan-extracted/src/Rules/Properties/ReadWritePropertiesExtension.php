<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Properties;

use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
interface ReadWritePropertiesExtension
{
    public function isAlwaysRead(\RectorPrefix20201227\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isAlwaysWritten(\RectorPrefix20201227\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isInitialized(\RectorPrefix20201227\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
}
