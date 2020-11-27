<?php

namespace _PhpScopera143bcca66cb\Bug2164;

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
class B extends \_PhpScopera143bcca66cb\Bug2164\A
{
    /**
     * @param B|string $arg
     * @return void
     */
    public function test($arg)
    {
        \_PhpScopera143bcca66cb\Bug2164\B::staticTest($arg);
    }
}
