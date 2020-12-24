<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface ParameterReflectionWithPhpDocs extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflection
{
    public function getPhpDocType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function getNativeType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
