<?php

namespace _PhpScoper88fe6e0ad041\ThrowClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper88fe6e0ad041\ThrowClassExists\Bar::class)) {
            return;
        }
        throw new \_PhpScoper88fe6e0ad041\ThrowClassExists\Bar();
    }
}
