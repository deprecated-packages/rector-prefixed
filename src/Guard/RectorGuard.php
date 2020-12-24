<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Guard;

use _PhpScopere8e811afab72\Rector\Core\Application\ActiveRectorsProvider;
use _PhpScopere8e811afab72\Rector\Core\Exception\NoRectorsLoadedException;
final class RectorGuard
{
    /**
     * @var ActiveRectorsProvider
     */
    private $activeRectorsProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider)
    {
        $this->activeRectorsProvider = $activeRectorsProvider;
    }
    public function ensureSomeRectorsAreRegistered() : void
    {
        if ($this->activeRectorsProvider->provide() !== []) {
            return;
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NoRectorsLoadedException();
    }
}
