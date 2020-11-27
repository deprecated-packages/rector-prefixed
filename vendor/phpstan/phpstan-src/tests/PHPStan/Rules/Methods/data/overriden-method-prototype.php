<?php

namespace _PhpScoper88fe6e0ad041\OverridenMethodPrototype;

class Foo
{
    protected function foo()
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\OverridenMethodPrototype\Foo
{
    public function foo()
    {
    }
}
function () {
    $bar = new \_PhpScoper88fe6e0ad041\OverridenMethodPrototype\Bar();
    $bar->foo();
};
