<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError3 implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\LineRuleError
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
