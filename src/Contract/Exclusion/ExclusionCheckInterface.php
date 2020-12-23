<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Contract\Exclusion;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\PhpRectorInterface;
interface ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoper0a2ac50786fa\PhpParser\Node $onNode) : bool;
}
