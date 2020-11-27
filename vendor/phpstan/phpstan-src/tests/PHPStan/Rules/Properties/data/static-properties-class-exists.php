<?php

namespace _PhpScoperbd5d0c5f7638\StaticPropertiesClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoperbd5d0c5f7638\StaticPropertiesClassExists\Bar::class)) {
            return;
        }
        echo \_PhpScoperbd5d0c5f7638\StaticPropertiesClassExists\Bar::$foo;
    }
}
