<?php

// lint >= 7.4
namespace _PhpScoper88fe6e0ad041\DefinedVariablesArrowFunctions;

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
