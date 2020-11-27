<?php

namespace _PhpScoper006a73f0e455\OverridenMethodPrototype;

class Foo
{
    protected function foo()
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\OverridenMethodPrototype\Foo
{
    public function foo()
    {
    }
}
function () {
    $bar = new \_PhpScoper006a73f0e455\OverridenMethodPrototype\Bar();
    $bar->foo();
};
