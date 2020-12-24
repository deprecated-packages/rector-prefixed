<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules;

interface MetadataRuleError extends \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleError
{
    /**
     * @return mixed[]
     */
    public function getMetadata() : array;
}
