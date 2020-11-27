<?php

namespace _PhpScoper26e51eeacccf\OverridenMethodPrototype;

class Foo
{
    protected function foo()
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\OverridenMethodPrototype\Foo
{
    public function foo()
    {
    }
}
function () {
    $bar = new \_PhpScoper26e51eeacccf\OverridenMethodPrototype\Bar();
    $bar->foo();
};
