<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PHPStan\Reflection\PropertyReflection;
interface ReadWritePropertiesExtension
{
    public function isAlwaysRead(\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isAlwaysWritten(\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isInitialized(\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
}
