<?php

namespace _PhpScoperbd5d0c5f7638\CallTraitMethods;

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
class Baz extends \_PhpScoperbd5d0c5f7638\CallTraitMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->unexistentMethod();
    }
}
