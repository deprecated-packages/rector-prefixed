<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

use PHPStan\Type\Type;
interface ParameterReflectionWithPhpDocs extends \RectorPrefix20201227\PHPStan\Reflection\ParameterReflection
{
    public function getPhpDocType() : \PHPStan\Type\Type;
    public function getNativeType() : \PHPStan\Type\Type;
}
