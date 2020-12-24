<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface ParameterReflection
{
    public function getName() : string;
    public function isOptional() : bool;
    public function getType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function passedByReference() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\PassedByReference;
    public function isVariadic() : bool;
    public function getDefaultValue() : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type;
}
