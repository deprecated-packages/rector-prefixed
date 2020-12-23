<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError51 implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleError, \_PhpScoper0a2ac50786fa\PHPStan\Rules\LineRuleError, \_PhpScoper0a2ac50786fa\PHPStan\Rules\IdentifierRuleError, \_PhpScoper0a2ac50786fa\PHPStan\Rules\MetadataRuleError
{
    /** @var string */
    public $message;
    /** @var int */
    public $line;
    /** @var string */
    public $identifier;
    /** @var mixed[] */
    public $metadata;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getLine() : int
    {
        return $this->line;
    }
    public function getIdentifier() : string
    {
        return $this->identifier;
    }
    /**
     * @return mixed[]
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }
}
