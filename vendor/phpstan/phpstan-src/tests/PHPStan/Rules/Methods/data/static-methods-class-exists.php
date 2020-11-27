<?php

namespace _PhpScopera143bcca66cb\StaticMethodsClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScopera143bcca66cb\StaticMethodsClassExists\Bar::class)) {
            return;
        }
        \_PhpScopera143bcca66cb\StaticMethodsClassExists\Bar::doBar();
    }
}
