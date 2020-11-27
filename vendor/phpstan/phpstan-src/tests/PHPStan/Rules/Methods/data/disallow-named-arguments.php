<?php

namespace _PhpScoperbd5d0c5f7638\DisallowNamedArguments;

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
