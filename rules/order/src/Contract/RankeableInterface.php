<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order\Contract;

interface RankeableInterface
{
    public function getName() : string;
    /**
     * @return bool[]|int[]
     */
    public function getRanks() : array;
}
