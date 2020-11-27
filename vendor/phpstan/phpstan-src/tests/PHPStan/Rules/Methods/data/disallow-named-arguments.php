<?php

namespace _PhpScopera143bcca66cb\DisallowNamedArguments;

class Foo
{
    public function doFoo() : void
    {
        $this->doBar(i: 1);
    }
    public function doBar(int $i) : void
    {
    }
}
