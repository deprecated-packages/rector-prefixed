<?php

namespace _PhpScopera143bcca66cb\ThrowClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScopera143bcca66cb\ThrowClassExists\Bar::class)) {
            return;
        }
        throw new \_PhpScopera143bcca66cb\ThrowClassExists\Bar();
    }
}
