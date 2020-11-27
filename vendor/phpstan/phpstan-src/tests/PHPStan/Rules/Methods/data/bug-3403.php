<?php

namespace _PhpScoperbd5d0c5f7638\Bug3403;

interface Foo
{
    public function bar(...$baz) : void;
}
class AFoo implements \_PhpScoperbd5d0c5f7638\Bug3403\Foo
{
    public function bar(...$baz) : void
    {
    }
}
