<?php

namespace _PhpScoper88fe6e0ad041\InheritDocWithoutCurlyBracesFromInterface2;

interface FooInterface extends \_PhpScoper88fe6e0ad041\InheritDocWithoutCurlyBracesFromInterface2\BarInterface
{
}
interface BarInterface
{
    /**
     * @param int $int
     */
    public function doBar($int);
}
