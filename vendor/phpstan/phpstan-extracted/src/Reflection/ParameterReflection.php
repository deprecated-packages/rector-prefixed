<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Type\Type;
interface ParameterReflection
{
    public function getName() : string;
    public function isOptional() : bool;
    public function getType() : \PHPStan\Type\Type;
    public function passedByReference() : \PHPStan\Reflection\PassedByReference;
    public function isVariadic() : bool;
    public function getDefaultValue() : ?\PHPStan\Type\Type;
}
