<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Exclusion;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\PhpRectorInterface;
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
    public function isNodeSkippedByRector(\_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoper0a2ac50786fa\PhpParser\Node $onNode) : bool
    {
        foreach ($this->exclusionChecks as $exclusionCheck) {
            if ($exclusionCheck->isNodeSkippedByRector($phpRector, $onNode)) {
                return \true;
            }
        }
        return \false;
    }
}
