<?php

// lint >= 7.4
namespace _PhpScoperabd03f0baf05\ArrowFunctionsInside;

class Foo
{
    public function doFoo(int $i)
    {
        fn(string $s) => die;
    }
}
