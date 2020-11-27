<?php

namespace _PhpScoper88fe6e0ad041\CallTraitMethods;

trait Foo
{
    public function fooMethod()
    {
    }
}
class Bar
{
    use Foo;
}
class Baz extends \_PhpScoper88fe6e0ad041\CallTraitMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->unexistentMethod();
    }
}
