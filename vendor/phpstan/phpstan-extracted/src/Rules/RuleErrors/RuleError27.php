<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError27 implements \_PhpScopere8e811afab72\PHPStan\Rules\RuleError, \_PhpScopere8e811afab72\PHPStan\Rules\LineRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\TipRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\IdentifierRuleError
{
    /** @var string */
    public $message;
    /** @var int */
    public $line;
    /** @var string */
    public $tip;
    /** @var string */
    public $identifier;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getLine() : int
    {
        return $this->line;
    }
    public function getTip() : string
    {
        return $this->tip;
    }
    public function getIdentifier() : string
    {
        return $this->identifier;
    }
}
