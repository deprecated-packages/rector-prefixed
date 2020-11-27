<?php

namespace _PhpScopera143bcca66cb\Bug3409;

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
