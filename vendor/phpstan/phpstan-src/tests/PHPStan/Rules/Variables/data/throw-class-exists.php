<?php

namespace _PhpScoperbd5d0c5f7638\ThrowClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoperbd5d0c5f7638\ThrowClassExists\Bar::class)) {
            return;
        }
        throw new \_PhpScoperbd5d0c5f7638\ThrowClassExists\Bar();
    }
}
