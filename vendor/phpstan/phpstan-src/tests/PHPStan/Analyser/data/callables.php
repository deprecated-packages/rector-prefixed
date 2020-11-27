<?php

namespace _PhpScoper006a73f0e455\Callables;

class Foo
{
    public function doFoo() : float
    {
        $closure = function () : string {
        };
        $foo = $this;
        $arrayWithStaticMethod = ['_PhpScoper006a73f0e455\\Callables\\Foo', 'doBar'];
        $stringWithStaticMethod = 'Callables\\Foo::doFoo';
        $arrayWithInstanceMethod = [$this, 'doFoo'];
        die;
    }
    public function doBar() : \_PhpScoper006a73f0e455\Callables\Bar
    {
    }
    public function __invoke() : int
    {
    }
}
