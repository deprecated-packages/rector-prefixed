<?php

namespace _PhpScoper006a73f0e455\Bug3409;

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
