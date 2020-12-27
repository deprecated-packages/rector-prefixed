<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

interface LineRuleError extends \RectorPrefix20201227\PHPStan\Rules\RuleError
{
    public function getLine() : int;
}
