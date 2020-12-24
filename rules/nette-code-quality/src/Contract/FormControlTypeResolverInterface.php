<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
interface FormControlTypeResolverInterface
{
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : array;
}
