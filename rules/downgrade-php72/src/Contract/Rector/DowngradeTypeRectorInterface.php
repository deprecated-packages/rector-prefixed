<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DowngradePhp72\Contract\Rector;

interface DowngradeTypeRectorInterface
{
    /**
     * Name of the type to remove
     */
    public function getTypeToRemove() : string;
}
