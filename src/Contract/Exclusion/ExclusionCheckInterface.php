<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Exclusion;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\PhpRectorInterface;
interface ExclusionCheckInterface
{
    public function isNodeSkippedByRector(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $onNode) : bool;
}
