<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Exclusion;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface;
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
    public function isNodeSkippedByRector(\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \_PhpScoperb75b35f52b74\PhpParser\Node $onNode) : bool
    {
        foreach ($this->exclusionChecks as $exclusionCheck) {
            if ($exclusionCheck->isNodeSkippedByRector($phpRector, $onNode)) {
                return \true;
            }
        }
        return \false;
    }
}
