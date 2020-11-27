<?php

// lint >= 7.4
namespace _PhpScoper006a73f0e455\ArrowFunctions;

class Foo
{
    public function doFoo()
    {
        $x = fn(string $str): int => 1;
        die;
    }
}
