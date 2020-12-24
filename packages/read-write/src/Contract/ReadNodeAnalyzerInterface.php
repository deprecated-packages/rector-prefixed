<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ReadWrite\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
interface ReadNodeAnalyzerInterface
{
    public function supports(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool;
    public function isRead(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool;
}
