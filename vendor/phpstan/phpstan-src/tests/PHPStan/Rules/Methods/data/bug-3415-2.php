<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Bug3415Two;

trait Foo
{
    public function bar() : void
    {
        echo "bar";
    }
}
class SomeClass
{
    use Foo {
        bar as baz;
    }
    public function __construct()
    {
        $this->bar();
        $this->baz();
    }
}
