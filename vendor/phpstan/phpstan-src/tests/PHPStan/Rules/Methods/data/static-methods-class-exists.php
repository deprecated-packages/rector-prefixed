<?php

namespace _PhpScoper26e51eeacccf\StaticMethodsClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper26e51eeacccf\StaticMethodsClassExists\Bar::class)) {
            return;
        }
        \_PhpScoper26e51eeacccf\StaticMethodsClassExists\Bar::doBar();
    }
}
