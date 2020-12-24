<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError23 implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\LineRuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\FileRuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\IdentifierRuleError
{
    /** @var string */
    public $message;
    /** @var int */
    public $line;
    /** @var string */
    public $file;
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
    public function getFile() : string
    {
        return $this->file;
    }
    public function getIdentifier() : string
    {
        return $this->identifier;
    }
}
