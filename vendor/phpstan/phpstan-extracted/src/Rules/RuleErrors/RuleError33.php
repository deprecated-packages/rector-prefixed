<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError33 implements \_PhpScopere8e811afab72\PHPStan\Rules\RuleError, \_PhpScopere8e811afab72\PHPStan\Rules\MetadataRuleError
{
    /** @var string */
    public $message;
    /** @var mixed[] */
    public $metadata;
    public function getMessage() : string
    {
        return $this->message;
    }
    /**
     * @return mixed[]
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }
}
