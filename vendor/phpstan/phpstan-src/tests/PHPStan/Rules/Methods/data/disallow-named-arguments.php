<?php

namespace _PhpScoperabd03f0baf05\DisallowNamedArguments;

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
