<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError99 implements \RectorPrefix20201227\PHPStan\Rules\RuleError, \RectorPrefix20201227\PHPStan\Rules\LineRuleError, \RectorPrefix20201227\PHPStan\Rules\MetadataRuleError, \RectorPrefix20201227\PHPStan\Rules\NonIgnorableRuleError
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
