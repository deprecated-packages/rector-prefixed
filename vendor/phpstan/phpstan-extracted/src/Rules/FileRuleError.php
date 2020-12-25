<?php

declare (strict_types=1);
namespace PHPStan\Rules;

interface FileRuleError extends \PHPStan\Rules\RuleError
{
    public function getFile() : string;
}
