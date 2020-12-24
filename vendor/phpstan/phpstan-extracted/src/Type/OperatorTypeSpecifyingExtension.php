<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

interface OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \_PhpScopere8e811afab72\PHPStan\Type\Type $leftSide, \_PhpScopere8e811afab72\PHPStan\Type\Type $rightSide) : bool;
    public function specifyType(string $operatorSigil, \_PhpScopere8e811afab72\PHPStan\Type\Type $leftSide, \_PhpScopere8e811afab72\PHPStan\Type\Type $rightSide) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
