<?php

declare (strict_types=1);
namespace PHPStan\Rules;

interface MetadataRuleError extends \PHPStan\Rules\RuleError
{
    /**
     * @return mixed[]
     */
    public function getMetadata() : array;
}
