<?php

declare (strict_types=1);
namespace PHPStan\Rules;

interface LineRuleError extends \PHPStan\Rules\RuleError
{
    public function getLine() : int;
}
