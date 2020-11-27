<?php

// lint >= 7.4
namespace _PhpScoper88fe6e0ad041\ArrowFunctions;

class Foo
{
    public function doFoo()
    {
        $x = fn(string $str): int => 1;
        die;
    }
}
