<?php

namespace _PhpScoper88fe6e0ad041\Bug2164;

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
class B extends \_PhpScoper88fe6e0ad041\Bug2164\A
{
    /**
     * @param B|string $arg
     * @return void
     */
    public function test($arg)
    {
        \_PhpScoper88fe6e0ad041\Bug2164\B::staticTest($arg);
    }
}
