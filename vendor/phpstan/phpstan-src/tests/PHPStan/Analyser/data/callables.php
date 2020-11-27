<?php

namespace _PhpScoperbd5d0c5f7638\Callables;

class Foo
{
    public function doFoo() : float
    {
        $closure = function () : string {
        };
        $foo = $this;
        $arrayWithStaticMethod = ['_PhpScoperbd5d0c5f7638\\Callables\\Foo', 'doBar'];
        $stringWithStaticMethod = 'Callables\\Foo::doFoo';
        $arrayWithInstanceMethod = [$this, 'doFoo'];
        die;
    }
    public function doBar() : \_PhpScoperbd5d0c5f7638\Callables\Bar
    {
    }
    public function __invoke() : int
    {
    }
}
