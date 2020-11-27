<?php

// lint >= 7.4
namespace _PhpScoper006a73f0e455\DefinedVariablesCoalesceAssign;

class Foo
{
    public function doFoo()
    {
        $a ??= 'foo';
        $b['foo'] ??= 'bar';
    }
    public function doBar()
    {
        $a ??= $b;
    }
}
