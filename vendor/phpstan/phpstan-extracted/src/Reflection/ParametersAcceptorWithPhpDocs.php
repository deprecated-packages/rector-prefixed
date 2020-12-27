<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

use PHPStan\Type\Type;
interface ParametersAcceptorWithPhpDocs extends \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor
{
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array;
    public function getPhpDocReturnType() : \PHPStan\Type\Type;
    public function getNativeReturnType() : \PHPStan\Type\Type;
}
