<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Exclusion;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface;
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
    public function isNodeSkippedByRector(\_PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScopere8e811afab72\PhpParser\Node $onNode) : bool
    {
        foreach ($this->exclusionChecks as $exclusionCheck) {
            if ($exclusionCheck->isNodeSkippedByRector($phpRector, $onNode)) {
                return \true;
            }
        }
        return \false;
    }
}
