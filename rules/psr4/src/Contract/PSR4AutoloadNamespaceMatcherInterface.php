<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PSR4\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
interface PSR4AutoloadNamespaceMatcherInterface
{
    public function getExpectedNamespace(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string;
}
