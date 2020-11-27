<?php

namespace _PhpScoper88fe6e0ad041\Bug3403;

interface Foo
{
    public function bar(...$baz) : void;
}
class AFoo implements \_PhpScoper88fe6e0ad041\Bug3403\Foo
{
    public function bar(...$baz) : void
    {
    }
}
