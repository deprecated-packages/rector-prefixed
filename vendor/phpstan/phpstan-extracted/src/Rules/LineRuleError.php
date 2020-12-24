<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules;

interface LineRuleError extends \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleError
{
    public function getLine() : int;
}
