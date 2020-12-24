<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface ParametersAcceptorWithPhpDocs extends \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptor
{
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array;
    public function getPhpDocReturnType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function getNativeReturnType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
}
