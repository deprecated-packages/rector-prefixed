<?php

namespace _PhpScoperabd03f0baf05\Callables;

class Foo
{
    public function doFoo() : float
    {
        $closure = function () : string {
        };
        $foo = $this;
        $arrayWithStaticMethod = ['_PhpScoperabd03f0baf05\\Callables\\Foo', 'doBar'];
        $stringWithStaticMethod = 'Callables\\Foo::doFoo';
        $arrayWithInstanceMethod = [$this, 'doFoo'];
        die;
    }
    public function doBar() : \_PhpScoperabd03f0baf05\Callables\Bar
    {
    }
    public function __invoke() : int
    {
    }
}
