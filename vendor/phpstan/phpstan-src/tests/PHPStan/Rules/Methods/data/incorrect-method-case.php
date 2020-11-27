<?php

namespace _PhpScoper88fe6e0ad041\IncorrectMethodCase;

class Foo
{
    public function fooBar()
    {
        $this->foobar();
        $this->fooBar();
    }
}
