<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Guard;

use _PhpScoper0a6b37af0871\Rector\Core\Application\ActiveRectorsProvider;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NoRectorsLoadedException;
final class RectorGuard
{
    /**
     * @var ActiveRectorsProvider
     */
    private $activeRectorsProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider)
    {
        $this->activeRectorsProvider = $activeRectorsProvider;
    }
    public function ensureSomeRectorsAreRegistered() : void
    {
        if ($this->activeRectorsProvider->provide() !== []) {
            return;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NoRectorsLoadedException();
    }
}
