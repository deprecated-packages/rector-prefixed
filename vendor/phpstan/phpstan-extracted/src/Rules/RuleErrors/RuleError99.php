<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError99 implements \_PhpScopere8e811afab72\PHPStan\Rules\RuleError, \_PhpScopere8e811afab72\PHPStan\Rules\LineRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\MetadataRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\NonIgnorableRuleError
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
