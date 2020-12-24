<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules;

interface MetadataRuleError extends \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleError
{
    /**
     * @return mixed[]
     */
    public function getMetadata() : array;
}
