<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Contract\Exclusion;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface;
interface ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoperb75b35f52b74\PhpParser\Node $onNode) : bool;
}
