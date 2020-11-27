<?php

namespace _PhpScopera143bcca66cb\StaticPropertiesClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScopera143bcca66cb\StaticPropertiesClassExists\Bar::class)) {
            return;
        }
        echo \_PhpScopera143bcca66cb\StaticPropertiesClassExists\Bar::$foo;
    }
}
