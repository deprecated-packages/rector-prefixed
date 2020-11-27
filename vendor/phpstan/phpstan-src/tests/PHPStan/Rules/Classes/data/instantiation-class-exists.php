<?php

namespace _PhpScopera143bcca66cb\InstantiationClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (\class_exists(\_PhpScopera143bcca66cb\InstantiationClassExists\Bar::class)) {
            $bar = new \_PhpScopera143bcca66cb\InstantiationClassExists\Bar();
        }
    }
}
