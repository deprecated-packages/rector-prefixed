<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

interface MetadataRuleError extends \RectorPrefix20201227\PHPStan\Rules\RuleError
{
    /**
     * @return mixed[]
     */
    public function getMetadata() : array;
}
