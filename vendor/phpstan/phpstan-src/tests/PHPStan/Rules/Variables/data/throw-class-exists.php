<?php

namespace _PhpScoper006a73f0e455\ThrowClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper006a73f0e455\ThrowClassExists\Bar::class)) {
            return;
        }
        throw new \_PhpScoper006a73f0e455\ThrowClassExists\Bar();
    }
}
