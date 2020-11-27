<?php

namespace _PhpScoper006a73f0e455\Bug3403;

interface Foo
{
    public function bar(...$baz) : void;
}
class AFoo implements \_PhpScoper006a73f0e455\Bug3403\Foo
{
    public function bar(...$baz) : void
    {
    }
}
