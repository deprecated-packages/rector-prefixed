<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

interface ConstantScalarType extends \_PhpScopere8e811afab72\PHPStan\Type\ConstantType
{
    /**
     * @return int|float|string|bool|null
     */
    public function getValue();
}
