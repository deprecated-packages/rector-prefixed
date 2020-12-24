<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Contract\Exclusion;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface;
interface ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\_PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScopere8e811afab72\PhpParser\Node $onNode) : bool;
}
