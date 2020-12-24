<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Order\Contract;

interface RankeableInterface
{
    public function getName() : string;
    /**
     * @return bool[]|int[]
     */
    public function getRanks() : array;
}
