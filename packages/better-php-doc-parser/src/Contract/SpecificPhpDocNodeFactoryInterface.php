<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract;

interface SpecificPhpDocNodeFactoryInterface extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface
{
    /**
     * @return string[]
     */
    public function getClasses() : array;
}
