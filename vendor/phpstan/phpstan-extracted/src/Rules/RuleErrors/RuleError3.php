<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError3 implements \RectorPrefix20201227\PHPStan\Rules\RuleError, \RectorPrefix20201227\PHPStan\Rules\LineRuleError
{
    /** @var string */
    public $message;
    /** @var int */
    public $line;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getLine() : int
    {
        return $this->line;
    }
}
