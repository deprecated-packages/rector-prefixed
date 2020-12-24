<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules;

interface MetadataRuleError extends \_PhpScopere8e811afab72\PHPStan\Rules\RuleError
{
    /**
     * @return mixed[]
     */
    public function getMetadata() : array;
}
