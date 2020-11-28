<?php

// lint >= 7.4
namespace _PhpScoperabd03f0baf05\DefinedVariablesCoalesceAssign;

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
