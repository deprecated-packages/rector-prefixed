<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\VendorLocker\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
interface NodeVendorLockerInterface
{
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool;
}
