<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules;

interface FileRuleError extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError
{
    public function getFile() : string;
}
