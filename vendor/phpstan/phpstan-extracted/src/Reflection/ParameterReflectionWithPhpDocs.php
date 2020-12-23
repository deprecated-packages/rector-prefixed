<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface ParameterReflectionWithPhpDocs extends \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection
{
    public function getPhpDocType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function getNativeType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
