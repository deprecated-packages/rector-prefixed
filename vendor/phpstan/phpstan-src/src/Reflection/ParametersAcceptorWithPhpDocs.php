<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Type\Type;
interface ParametersAcceptorWithPhpDocs extends \PHPStan\Reflection\ParametersAcceptor
{
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array;
    public function getPhpDocReturnType() : \PHPStan\Type\Type;
    public function getNativeReturnType() : \PHPStan\Type\Type;
}
