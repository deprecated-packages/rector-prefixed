<?php

// lint >= 7.4
namespace _PhpScoper26e51eeacccf\DefinedVariablesArrowFunctions;

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
