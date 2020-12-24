<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

interface ConstantReflection extends \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection, \_PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection
{
    /**
     * @return mixed
     */
    public function getValue();
}
