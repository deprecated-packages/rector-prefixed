<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

interface IdentifierRuleError extends \RectorPrefix20201227\PHPStan\Rules\RuleError
{
    public function getIdentifier() : string;
}
