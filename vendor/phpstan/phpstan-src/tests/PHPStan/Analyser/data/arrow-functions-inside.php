<?php

// lint >= 7.4
namespace _PhpScoper88fe6e0ad041\ArrowFunctionsInside;

class Foo
{
    public function doFoo(int $i)
    {
        fn(string $s) => die;
    }
}
