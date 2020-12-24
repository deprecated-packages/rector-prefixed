<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp72\Contract\Rector;

interface DowngradeTypeRectorInterface
{
    /**
     * Name of the type to remove
     */
    public function getTypeToRemove() : string;
}
