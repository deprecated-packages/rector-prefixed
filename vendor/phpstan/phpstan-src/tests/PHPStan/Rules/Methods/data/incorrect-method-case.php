<?php

namespace _PhpScoper006a73f0e455\IncorrectMethodCase;

class Foo
{
    public function fooBar()
    {
        $this->foobar();
        $this->fooBar();
    }
}
