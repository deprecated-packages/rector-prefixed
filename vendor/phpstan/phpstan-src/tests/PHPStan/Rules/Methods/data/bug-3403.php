<?php

namespace _PhpScoperabd03f0baf05\Bug3403;

interface Foo
{
    public function bar(...$baz) : void;
}
class AFoo implements \_PhpScoperabd03f0baf05\Bug3403\Foo
{
    public function bar(...$baz) : void
    {
    }
}
