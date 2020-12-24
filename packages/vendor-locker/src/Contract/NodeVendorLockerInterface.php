<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\VendorLocker\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
interface NodeVendorLockerInterface
{
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool;
}
