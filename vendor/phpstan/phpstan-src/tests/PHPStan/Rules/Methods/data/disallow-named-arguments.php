<?php

namespace _PhpScoper006a73f0e455\DisallowNamedArguments;

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
