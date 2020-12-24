<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Logging;

use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface;
final class CurrentRectorProvider
{
    /**
     * @var RectorInterface|null
     */
    private $currentRector;
    public function changeCurrentRector(\_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface $rector) : void
    {
        $this->currentRector = $rector;
    }
    public function getCurrentRector() : ?\_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface
    {
        return $this->currentRector;
    }
}
