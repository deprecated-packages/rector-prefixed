<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order\Contract;

interface RankeableInterface
{
    public function getName() : string;
    /**
     * @return bool[]|int[]
     */
    public function getRanks() : array;
}
