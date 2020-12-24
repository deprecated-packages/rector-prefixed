<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Order\Contract;

interface RankeableInterface
{
    public function getName() : string;
    /**
     * @return bool[]|int[]
     */
    public function getRanks() : array;
}
