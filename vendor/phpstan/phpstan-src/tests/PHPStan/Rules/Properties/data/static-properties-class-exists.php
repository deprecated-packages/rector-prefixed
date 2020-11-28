<?php

namespace _PhpScoperabd03f0baf05\StaticPropertiesClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoperabd03f0baf05\StaticPropertiesClassExists\Bar::class)) {
            return;
        }
        echo \_PhpScoperabd03f0baf05\StaticPropertiesClassExists\Bar::$foo;
    }
}
