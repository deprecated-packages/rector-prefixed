<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Traits;

use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
trait FalseyBooleanTypeTrait
{
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
}
