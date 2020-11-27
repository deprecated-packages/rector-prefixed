<?php

namespace _PhpScoperbd5d0c5f7638\Bug3409;

class Foo
{
    public function doFoo()
    {
        $this->doBar();
    }
    public function doBar(?callable $callback = null, ...$args) : void
    {
    }
}
