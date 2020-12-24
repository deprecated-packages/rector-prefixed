<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError113 implements \_PhpScopere8e811afab72\PHPStan\Rules\RuleError, \_PhpScopere8e811afab72\PHPStan\Rules\IdentifierRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\MetadataRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\NonIgnorableRuleError
{
    /** @var string */
    public $message;
    /** @var string */
    public $identifier;
    /** @var mixed[] */
    public $metadata;
    public function getMessage() : string
    {
        return $this->message;
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
