<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface ParametersAcceptorWithPhpDocs extends \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor
{
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array;
    public function getPhpDocReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function getNativeReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
