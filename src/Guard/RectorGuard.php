<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Guard;

use _PhpScoper0a2ac50786fa\Rector\Core\Application\ActiveRectorsProvider;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NoRectorsLoadedException;
final class RectorGuard
{
    /**
     * @var ActiveRectorsProvider
     */
    private $activeRectorsProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider)
    {
        $this->activeRectorsProvider = $activeRectorsProvider;
    }
    public function ensureSomeRectorsAreRegistered() : void
    {
        if ($this->activeRectorsProvider->provide() !== []) {
            return;
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NoRectorsLoadedException();
    }
}
