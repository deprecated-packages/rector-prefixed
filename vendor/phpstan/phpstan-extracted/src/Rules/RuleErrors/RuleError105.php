<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError105 implements \_PhpScopere8e811afab72\PHPStan\Rules\RuleError, \_PhpScopere8e811afab72\PHPStan\Rules\TipRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\MetadataRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\NonIgnorableRuleError
{
    /** @var string */
    public $message;
    /** @var string */
    public $tip;
    /** @var mixed[] */
    public $metadata;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getTip() : string
    {
        return $this->tip;
    }
    /**
     * @return mixed[]
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }
}
