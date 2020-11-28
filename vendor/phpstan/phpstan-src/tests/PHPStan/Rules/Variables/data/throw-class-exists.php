<?php

namespace _PhpScoperabd03f0baf05\ThrowClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoperabd03f0baf05\ThrowClassExists\Bar::class)) {
            return;
        }
        throw new \_PhpScoperabd03f0baf05\ThrowClassExists\Bar();
    }
}
