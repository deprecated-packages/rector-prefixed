<?php

namespace _PhpScoper006a73f0e455\CallTraitMethods;

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
class Baz extends \_PhpScoper006a73f0e455\CallTraitMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->unexistentMethod();
    }
}
