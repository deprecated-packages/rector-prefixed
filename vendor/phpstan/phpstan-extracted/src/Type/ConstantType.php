<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

interface ConstantType extends \_PhpScopere8e811afab72\PHPStan\Type\Type
{
    public function generalize() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
