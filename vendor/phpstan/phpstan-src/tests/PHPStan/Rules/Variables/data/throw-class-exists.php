<?php

namespace _PhpScoper26e51eeacccf\ThrowClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper26e51eeacccf\ThrowClassExists\Bar::class)) {
            return;
        }
        throw new \_PhpScoper26e51eeacccf\ThrowClassExists\Bar();
    }
}
