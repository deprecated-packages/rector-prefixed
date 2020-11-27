<?php

namespace _PhpScopera143bcca66cb\CallTraitMethods;

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
class Baz extends \_PhpScopera143bcca66cb\CallTraitMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->unexistentMethod();
    }
}
