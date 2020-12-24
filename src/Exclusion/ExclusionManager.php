<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Exclusion;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\PhpRectorInterface;
final class ExclusionManager
{
    /**
     * @var ExclusionCheckInterface[]
     */
    private $exclusionChecks = [];
    /**
     * @param ExclusionCheckInterface[] $exclusionChecks
     */
    public function __construct(array $exclusionChecks = [])
    {
        $this->exclusionChecks = $exclusionChecks;
    }
    public function isNodeSkippedByRector(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $onNode) : bool
    {
        foreach ($this->exclusionChecks as $exclusionCheck) {
            if ($exclusionCheck->isNodeSkippedByRector($phpRector, $onNode)) {
                return \true;
            }
        }
        return \false;
    }
}
