<?php

namespace _PhpScoperbd5d0c5f7638\OverridenMethodPrototype;

class Foo
{
    protected function foo()
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\OverridenMethodPrototype\Foo
{
    public function foo()
    {
    }
}
function () {
    $bar = new \_PhpScoperbd5d0c5f7638\OverridenMethodPrototype\Bar();
    $bar->foo();
};
