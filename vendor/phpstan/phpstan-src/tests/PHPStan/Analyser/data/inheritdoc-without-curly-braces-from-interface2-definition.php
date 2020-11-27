<?php

namespace _PhpScoperbd5d0c5f7638\InheritDocWithoutCurlyBracesFromInterface2;

interface FooInterface extends \_PhpScoperbd5d0c5f7638\InheritDocWithoutCurlyBracesFromInterface2\BarInterface
{
}
interface BarInterface
{
    /**
     * @param int $int
     */
    public function doBar($int);
}
