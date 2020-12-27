<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

interface FileRuleError extends \RectorPrefix20201227\PHPStan\Rules\RuleError
{
    public function getFile() : string;
}
