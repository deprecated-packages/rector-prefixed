<?php

namespace _PhpScoper006a73f0e455\StaticPropertiesClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper006a73f0e455\StaticPropertiesClassExists\Bar::class)) {
            return;
        }
        echo \_PhpScoper006a73f0e455\StaticPropertiesClassExists\Bar::$foo;
    }
}
