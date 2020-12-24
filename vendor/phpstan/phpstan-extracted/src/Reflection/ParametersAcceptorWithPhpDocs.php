<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface ParametersAcceptorWithPhpDocs extends \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor
{
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array;
    public function getPhpDocReturnType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function getNativeReturnType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
