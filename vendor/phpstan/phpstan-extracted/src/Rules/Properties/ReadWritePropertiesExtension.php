<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
interface ReadWritePropertiesExtension
{
    public function isAlwaysRead(\_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isAlwaysWritten(\_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isInitialized(\_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
}
