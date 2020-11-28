<?php

namespace _PhpScoperabd03f0baf05\StaticMethodsClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoperabd03f0baf05\StaticMethodsClassExists\Bar::class)) {
            return;
        }
        \_PhpScoperabd03f0baf05\StaticMethodsClassExists\Bar::doBar();
    }
}
