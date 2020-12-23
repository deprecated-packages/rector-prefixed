<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Order\Contract;

interface RankeableInterface
{
    public function getName() : string;
    /**
     * @return bool[]|int[]
     */
    public function getRanks() : array;
}
