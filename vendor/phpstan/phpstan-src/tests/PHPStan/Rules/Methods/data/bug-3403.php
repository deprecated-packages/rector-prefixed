<?php

namespace _PhpScopera143bcca66cb\Bug3403;

interface Foo
{
    public function bar(...$baz) : void;
}
class AFoo implements \_PhpScopera143bcca66cb\Bug3403\Foo
{
    public function bar(...$baz) : void
    {
    }
}
