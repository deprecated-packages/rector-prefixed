<?php

namespace _PhpScoperbd5d0c5f7638\StaticMethodsClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoperbd5d0c5f7638\StaticMethodsClassExists\Bar::class)) {
            return;
        }
        \_PhpScoperbd5d0c5f7638\StaticMethodsClassExists\Bar::doBar();
    }
}
