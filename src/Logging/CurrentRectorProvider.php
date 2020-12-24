<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Logging;

use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface;
final class CurrentRectorProvider
{
    /**
     * @var RectorInterface|null
     */
    private $currentRector;
    public function changeCurrentRector(\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface $rector) : void
    {
        $this->currentRector = $rector;
    }
    public function getCurrentRector() : ?\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface
    {
        return $this->currentRector;
    }
}
