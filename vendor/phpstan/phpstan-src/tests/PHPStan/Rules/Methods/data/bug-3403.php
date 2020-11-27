<?php

namespace _PhpScoper26e51eeacccf\Bug3403;

interface Foo
{
    public function bar(...$baz) : void;
}
class AFoo implements \_PhpScoper26e51eeacccf\Bug3403\Foo
{
    public function bar(...$baz) : void
    {
    }
}
