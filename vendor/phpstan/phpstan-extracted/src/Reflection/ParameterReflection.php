<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface ParameterReflection
{
    public function getName() : string;
    public function isOptional() : bool;
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function passedByReference() : \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference;
    public function isVariadic() : bool;
    public function getDefaultValue() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type;
}
