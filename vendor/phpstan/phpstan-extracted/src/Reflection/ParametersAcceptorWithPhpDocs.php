<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface ParametersAcceptorWithPhpDocs extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor
{
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array;
    public function getPhpDocReturnType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function getNativeReturnType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
