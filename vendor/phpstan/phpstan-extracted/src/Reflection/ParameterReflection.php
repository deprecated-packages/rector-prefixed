<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface ParameterReflection
{
    public function getName() : string;
    public function isOptional() : bool;
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function passedByReference() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference;
    public function isVariadic() : bool;
    public function getDefaultValue() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
