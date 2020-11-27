<?php

namespace _PhpScoperbd5d0c5f7638\IncorrectMethodCase;

class Foo
{
    public function fooBar()
    {
        $this->foobar();
        $this->fooBar();
    }
}
