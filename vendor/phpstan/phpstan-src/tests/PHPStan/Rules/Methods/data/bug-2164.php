<?php

namespace _PhpScoper006a73f0e455\Bug2164;

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
class B extends \_PhpScoper006a73f0e455\Bug2164\A
{
    /**
     * @param B|string $arg
     * @return void
     */
    public function test($arg)
    {
        \_PhpScoper006a73f0e455\Bug2164\B::staticTest($arg);
    }
}
