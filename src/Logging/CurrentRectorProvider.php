<?php

declare (strict_types=1);
namespace Rector\Core\Logging;

use Rector\Core\Contract\Rector\RectorInterface;
final class CurrentRectorProvider
{
    /**
     * @var RectorInterface|null
     */
    private $currentRector;
    /**
     * @return void
     */
    public function changeCurrentRector(\Rector\Core\Contract\Rector\RectorInterface $rector)
    {
        $this->currentRector = $rector;
    }
    public function getCurrentRector() : ?\Rector\Core\Contract\Rector\RectorInterface
    {
        return $this->currentRector;
    }
}
