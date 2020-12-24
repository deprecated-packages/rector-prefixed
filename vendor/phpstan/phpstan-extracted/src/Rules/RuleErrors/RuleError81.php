<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError81 implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\IdentifierRuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\NonIgnorableRuleError
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
