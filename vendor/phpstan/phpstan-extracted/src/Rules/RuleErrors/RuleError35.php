<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError35 implements \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleError, \_PhpScoper0a6b37af0871\PHPStan\Rules\LineRuleError, \_PhpScoper0a6b37af0871\PHPStan\Rules\MetadataRuleError
{
    /** @var string */
    public $message;
    /** @var int */
    public $line;
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
    /**
     * @return mixed[]
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }
}
