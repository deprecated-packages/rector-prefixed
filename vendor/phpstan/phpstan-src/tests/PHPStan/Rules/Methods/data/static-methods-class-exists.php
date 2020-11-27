<?php

namespace _PhpScoper88fe6e0ad041\StaticMethodsClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper88fe6e0ad041\StaticMethodsClassExists\Bar::class)) {
            return;
        }
        \_PhpScoper88fe6e0ad041\StaticMethodsClassExists\Bar::doBar();
    }
}
