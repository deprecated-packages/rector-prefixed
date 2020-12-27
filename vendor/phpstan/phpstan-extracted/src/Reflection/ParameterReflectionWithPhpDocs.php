<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Type\Type;
interface ParameterReflectionWithPhpDocs extends \PHPStan\Reflection\ParameterReflection
{
    public function getPhpDocType() : \PHPStan\Type\Type;
    public function getNativeType() : \PHPStan\Type\Type;
}
