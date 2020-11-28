<?php

// lint >= 7.4
namespace _PhpScoperabd03f0baf05\DefinedVariablesArrowFunctions;

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
