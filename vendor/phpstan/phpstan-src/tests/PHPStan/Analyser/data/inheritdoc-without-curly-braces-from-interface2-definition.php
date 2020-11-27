<?php

namespace _PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromInterface2;

interface FooInterface extends \_PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromInterface2\BarInterface
{
}
interface BarInterface
{
    /**
     * @param int $int
     */
    public function doBar($int);
}
