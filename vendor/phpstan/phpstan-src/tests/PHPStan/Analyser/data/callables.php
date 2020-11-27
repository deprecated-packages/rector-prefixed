<?php

namespace _PhpScoper26e51eeacccf\Callables;

class Foo
{
    public function doFoo() : float
    {
        $closure = function () : string {
        };
        $foo = $this;
        $arrayWithStaticMethod = ['_PhpScoper26e51eeacccf\\Callables\\Foo', 'doBar'];
        $stringWithStaticMethod = 'Callables\\Foo::doFoo';
        $arrayWithInstanceMethod = [$this, 'doFoo'];
        die;
    }
    public function doBar() : \_PhpScoper26e51eeacccf\Callables\Bar
    {
    }
    public function __invoke() : int
    {
    }
}
