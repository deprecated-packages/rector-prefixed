<?php

namespace _PhpScoper006a73f0e455\StaticMethodsClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper006a73f0e455\StaticMethodsClassExists\Bar::class)) {
            return;
        }
        \_PhpScoper006a73f0e455\StaticMethodsClassExists\Bar::doBar();
    }
}
