<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Guard;

use _PhpScoperb75b35f52b74\Rector\Core\Application\ActiveRectorsProvider;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NoRectorsLoadedException;
final class RectorGuard
{
    /**
     * @var ActiveRectorsProvider
     */
    private $activeRectorsProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider)
    {
        $this->activeRectorsProvider = $activeRectorsProvider;
    }
    public function ensureSomeRectorsAreRegistered() : void
    {
        if ($this->activeRectorsProvider->provide() !== []) {
            return;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NoRectorsLoadedException();
    }
}
