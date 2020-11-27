<?php

namespace _PhpScopera143bcca66cb\Callables;

class Foo
{
    public function doFoo() : float
    {
        $closure = function () : string {
        };
        $foo = $this;
        $arrayWithStaticMethod = ['_PhpScopera143bcca66cb\\Callables\\Foo', 'doBar'];
        $stringWithStaticMethod = 'Callables\\Foo::doFoo';
        $arrayWithInstanceMethod = [$this, 'doFoo'];
        die;
    }
    public function doBar() : \_PhpScopera143bcca66cb\Callables\Bar
    {
    }
    public function __invoke() : int
    {
    }
}
