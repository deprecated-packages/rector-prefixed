<?php

namespace _PhpScoperabd03f0baf05\OverridenMethodPrototype;

class Foo
{
    protected function foo()
    {
    }
}
class Bar extends \_PhpScoperabd03f0baf05\OverridenMethodPrototype\Foo
{
    public function foo()
    {
    }
}
function () {
    $bar = new \_PhpScoperabd03f0baf05\OverridenMethodPrototype\Bar();
    $bar->foo();
};
