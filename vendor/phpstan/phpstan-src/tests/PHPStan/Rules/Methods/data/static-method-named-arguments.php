<?php

namespace _PhpScoper88fe6e0ad041\StaticMethodNamedArguments;

class Foo
{
    public static function doFoo(int $i, int $j) : void
    {
    }
    public function doBar() : void
    {
        self::doFoo(i: 1);
        self::doFoo(i: 1, j: 2, z: 3);
    }
}
