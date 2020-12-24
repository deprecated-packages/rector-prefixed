<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Properties;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection;
interface ReadWritePropertiesExtension
{
    public function isAlwaysRead(\_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isAlwaysWritten(\_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isInitialized(\_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
}
