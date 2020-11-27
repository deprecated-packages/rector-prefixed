<?php

namespace _PhpScopera143bcca66cb\OverridenMethodPrototype;

class Foo
{
    protected function foo()
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\OverridenMethodPrototype\Foo
{
    public function foo()
    {
    }
}
function () {
    $bar = new \_PhpScopera143bcca66cb\OverridenMethodPrototype\Bar();
    $bar->foo();
};
