<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

interface TipRuleError extends \RectorPrefix20201227\PHPStan\Rules\RuleError
{
    public function getTip() : string;
}
