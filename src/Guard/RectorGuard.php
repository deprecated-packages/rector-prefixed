<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Guard;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\Application\ActiveRectorsProvider;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NoRectorsLoadedException;
final class RectorGuard
{
    /**
     * @var ActiveRectorsProvider
     */
    private $activeRectorsProvider;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider)
    {
        $this->activeRectorsProvider = $activeRectorsProvider;
    }
    public function ensureSomeRectorsAreRegistered() : void
    {
        if ($this->activeRectorsProvider->provide() !== []) {
            return;
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NoRectorsLoadedException();
    }
}
