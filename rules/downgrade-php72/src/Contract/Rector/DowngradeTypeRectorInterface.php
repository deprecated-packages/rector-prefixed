<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp72\Contract\Rector;

interface DowngradeTypeRectorInterface
{
    /**
     * Name of the type to remove
     */
    public function getTypeToRemove() : string;
}
