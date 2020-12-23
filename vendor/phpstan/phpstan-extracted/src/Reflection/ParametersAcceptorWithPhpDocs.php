<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface ParametersAcceptorWithPhpDocs extends \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor
{
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array;
    public function getPhpDocReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function getNativeReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
