<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules;

interface LineRuleError extends \_PhpScopere8e811afab72\PHPStan\Rules\RuleError
{
    public function getLine() : int;
}
