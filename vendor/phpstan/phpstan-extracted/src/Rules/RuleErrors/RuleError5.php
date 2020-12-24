<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError5 implements \_PhpScopere8e811afab72\PHPStan\Rules\RuleError, \_PhpScopere8e811afab72\PHPStan\Rules\FileRuleError
{
    /** @var string */
    public $message;
    /** @var string */
    public $file;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getFile() : string
    {
        return $this->file;
    }
}
