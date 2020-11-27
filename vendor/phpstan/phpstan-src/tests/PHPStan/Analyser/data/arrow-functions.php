<?php

// lint >= 7.4
namespace _PhpScoper26e51eeacccf\ArrowFunctions;

class Foo
{
    public function doFoo()
    {
        $x = fn(string $str): int => 1;
        die;
    }
}
