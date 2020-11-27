<?php

// lint >= 7.4
namespace _PhpScoperbd5d0c5f7638\DefinedVariablesArrowFunctions;

class Foo
{
    public function doFoo()
    {
        fn() => $a;
        fn(int $a) => $a;
        $local = 1;
        fn() => $local;
        fn() => $this->test;
        static fn() => $this->test;
    }
}
