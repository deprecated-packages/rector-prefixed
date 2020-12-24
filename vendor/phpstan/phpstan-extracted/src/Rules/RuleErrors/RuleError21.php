<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError21 implements \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleError, \_PhpScoper0a6b37af0871\PHPStan\Rules\FileRuleError, \_PhpScoper0a6b37af0871\PHPStan\Rules\IdentifierRuleError
{
    /** @var string */
    public $message;
    /** @var string */
    public $file;
    /** @var string */
    public $identifier;
    public function getMessage() : string
    {
        return $this->message;
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
