<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ReadWrite\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
interface ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool;
    public function isRead(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool;
}
