<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Properties;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
interface ReadWritePropertiesExtension
{
    public function isAlwaysRead(\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isAlwaysWritten(\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isInitialized(\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
}
