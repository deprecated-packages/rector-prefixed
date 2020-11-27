<?php

// lint >= 7.4
namespace _PhpScoper88fe6e0ad041\DefinedVariablesCoalesceAssign;

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
