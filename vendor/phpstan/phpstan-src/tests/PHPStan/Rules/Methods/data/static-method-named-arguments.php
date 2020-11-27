<?php

namespace _PhpScoper26e51eeacccf\StaticMethodNamedArguments;

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
