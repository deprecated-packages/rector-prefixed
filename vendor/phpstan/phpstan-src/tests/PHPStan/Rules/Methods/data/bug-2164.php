<?php

namespace _PhpScoperabd03f0baf05\Bug2164;

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
class B extends \_PhpScoperabd03f0baf05\Bug2164\A
{
    /**
     * @param B|string $arg
     * @return void
     */
    public function test($arg)
    {
        \_PhpScoperabd03f0baf05\Bug2164\B::staticTest($arg);
    }
}
