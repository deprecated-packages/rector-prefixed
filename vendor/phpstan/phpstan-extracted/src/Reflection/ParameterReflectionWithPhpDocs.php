<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface ParameterReflectionWithPhpDocs extends \_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection
{
    public function getPhpDocType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    public function getNativeType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
