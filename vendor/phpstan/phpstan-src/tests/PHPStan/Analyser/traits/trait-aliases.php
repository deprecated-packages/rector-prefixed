<?php

namespace _PhpScoper88fe6e0ad041\TraitAliases;

trait BazTrait
{
    public function fooMethod() : void
    {
    }
}
trait BarTrait
{
    use BazTrait {
        fooMethod as parentFooMethod;
    }
    public function fooMethod() : void
    {
        // some code ...
        $this->fooMethod();
        $this->parentFooMethod();
    }
}
class Foo
{
    use BarTrait;
    public function doFoo() : void
    {
        $this->fooMethod();
        $this->parentFooMethod();
    }
}
