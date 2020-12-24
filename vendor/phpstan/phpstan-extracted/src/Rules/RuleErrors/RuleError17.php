<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError17 implements \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleError, \_PhpScoperb75b35f52b74\PHPStan\Rules\IdentifierRuleError
{
    /** @var string */
    public $message;
    /** @var string */
    public $identifier;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getIdentifier() : string
    {
        return $this->identifier;
    }
}
