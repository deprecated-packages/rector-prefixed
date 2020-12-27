<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError53 implements \RectorPrefix20201227\PHPStan\Rules\RuleError, \RectorPrefix20201227\PHPStan\Rules\FileRuleError, \RectorPrefix20201227\PHPStan\Rules\IdentifierRuleError, \RectorPrefix20201227\PHPStan\Rules\MetadataRuleError
{
    /** @var string */
    public $message;
    /** @var string */
    public $file;
    /** @var string */
    public $identifier;
    /** @var mixed[] */
    public $metadata;
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
    /**
     * @return mixed[]
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }
}
