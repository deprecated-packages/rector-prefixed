<?php

namespace _PhpScoper88fe6e0ad041\Callables;

class Foo
{
    public function doFoo() : float
    {
        $closure = function () : string {
        };
        $foo = $this;
        $arrayWithStaticMethod = ['_PhpScoper88fe6e0ad041\\Callables\\Foo', 'doBar'];
        $stringWithStaticMethod = 'Callables\\Foo::doFoo';
        $arrayWithInstanceMethod = [$this, 'doFoo'];
        die;
    }
    public function doBar() : \_PhpScoper88fe6e0ad041\Callables\Bar
    {
    }
    public function __invoke() : int
    {
    }
}
