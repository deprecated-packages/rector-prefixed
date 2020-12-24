<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface ParameterReflectionWithPhpDocs extends \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParameterReflection
{
    public function getPhpDocType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function getNativeType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
}
