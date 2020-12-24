<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Logging;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\RectorInterface;
final class CurrentRectorProvider
{
    /**
     * @var RectorInterface|null
     */
    private $currentRector;
    public function changeCurrentRector(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\RectorInterface $rector) : void
    {
        $this->currentRector = $rector;
    }
    public function getCurrentRector() : ?\_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\RectorInterface
    {
        return $this->currentRector;
    }
}
