<?php

// lint >= 7.4
namespace _PhpScoper26e51eeacccf\DefinedVariablesCoalesceAssign;

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
