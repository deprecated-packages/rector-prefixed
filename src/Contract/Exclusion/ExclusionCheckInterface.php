<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Contract\Exclusion;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\PhpRectorInterface;
interface ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoper0a6b37af0871\PhpParser\Node $onNode) : bool;
}
