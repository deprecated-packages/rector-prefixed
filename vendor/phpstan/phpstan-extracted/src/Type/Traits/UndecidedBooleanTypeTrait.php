<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Traits;

use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
trait UndecidedBooleanTypeTrait
{
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
    }
}
