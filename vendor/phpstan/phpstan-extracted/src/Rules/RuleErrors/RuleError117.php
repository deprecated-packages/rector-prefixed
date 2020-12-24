<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError117 implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\FileRuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\IdentifierRuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\MetadataRuleError, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\NonIgnorableRuleError
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
