<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\VendorLocker\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
interface NodeVendorLockerInterface
{
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool;
}
