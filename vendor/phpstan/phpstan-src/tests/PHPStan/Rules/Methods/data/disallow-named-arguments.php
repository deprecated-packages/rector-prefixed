<?php

namespace _PhpScoper26e51eeacccf\DisallowNamedArguments;

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
