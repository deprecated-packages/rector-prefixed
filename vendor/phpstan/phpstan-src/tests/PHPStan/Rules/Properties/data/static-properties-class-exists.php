<?php

namespace _PhpScoper26e51eeacccf\StaticPropertiesClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper26e51eeacccf\StaticPropertiesClassExists\Bar::class)) {
            return;
        }
        echo \_PhpScoper26e51eeacccf\StaticPropertiesClassExists\Bar::$foo;
    }
}
