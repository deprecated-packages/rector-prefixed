<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Properties;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
interface ReadWritePropertiesExtension
{
    public function isAlwaysRead(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isAlwaysWritten(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isInitialized(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
}
