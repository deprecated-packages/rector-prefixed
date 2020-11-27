<?php

declare (strict_types=1);
namespace PHPStan\Rules;

interface TipRuleError extends \PHPStan\Rules\RuleError
{
    public function getTip() : string;
}
