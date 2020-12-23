<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\VendorLocker\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
interface NodeVendorLockerInterface
{
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool;
}
