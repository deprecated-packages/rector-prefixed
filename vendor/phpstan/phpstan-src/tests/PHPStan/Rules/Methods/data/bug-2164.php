<?php

namespace _PhpScoperbd5d0c5f7638\Bug2164;

class A
{
    /**
     * @param static|string $arg
     * @return void
     */
    public static function staticTest($arg)
    {
    }
}
class B extends \_PhpScoperbd5d0c5f7638\Bug2164\A
{
    /**
     * @param B|string $arg
     * @return void
     */
    public function test($arg)
    {
        \_PhpScoperbd5d0c5f7638\Bug2164\B::staticTest($arg);
    }
}
