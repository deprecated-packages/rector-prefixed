<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError3 implements \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleError, \_PhpScoperb75b35f52b74\PHPStan\Rules\LineRuleError
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
