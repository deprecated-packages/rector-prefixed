<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

interface RuleError
{
    public function getMessage() : string;
}
