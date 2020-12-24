<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Constant;

use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
trait ConstantScalarToBooleanTrait
{
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType((bool) $this->value);
    }
}
