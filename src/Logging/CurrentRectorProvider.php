<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Logging;

use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\RectorInterface;
final class CurrentRectorProvider
{
    /**
     * @var RectorInterface|null
     */
    private $currentRector;
    public function changeCurrentRector(\_PhpScopere8e811afab72\Rector\Core\Contract\Rector\RectorInterface $rector) : void
    {
        $this->currentRector = $rector;
    }
    public function getCurrentRector() : ?\_PhpScopere8e811afab72\Rector\Core\Contract\Rector\RectorInterface
    {
        return $this->currentRector;
    }
}
