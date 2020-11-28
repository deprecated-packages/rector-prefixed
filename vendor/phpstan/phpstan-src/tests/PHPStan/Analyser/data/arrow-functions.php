<?php

// lint >= 7.4
namespace _PhpScoperabd03f0baf05\ArrowFunctions;

class Foo
{
    public function doFoo()
    {
        $x = fn(string $str): int => 1;
        die;
    }
}
