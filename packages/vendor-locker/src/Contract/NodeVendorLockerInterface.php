<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
interface NodeVendorLockerInterface
{
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool;
}
