<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError37 implements \_PhpScopere8e811afab72\PHPStan\Rules\RuleError, \_PhpScopere8e811afab72\PHPStan\Rules\FileRuleError, \_PhpScopere8e811afab72\PHPStan\Rules\MetadataRuleError
{
    /** @var string */
    public $message;
    /** @var string */
    public $file;
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
    /**
     * @return mixed[]
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }
}
