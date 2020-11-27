<?php

namespace _PhpScoper88fe6e0ad041\InstantiationClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (\class_exists(\_PhpScoper88fe6e0ad041\InstantiationClassExists\Bar::class)) {
            $bar = new \_PhpScoper88fe6e0ad041\InstantiationClassExists\Bar();
        }
    }
}
