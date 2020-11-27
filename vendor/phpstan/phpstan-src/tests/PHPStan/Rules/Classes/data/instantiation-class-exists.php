<?php

namespace _PhpScoper006a73f0e455\InstantiationClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (\class_exists(\_PhpScoper006a73f0e455\InstantiationClassExists\Bar::class)) {
            $bar = new \_PhpScoper006a73f0e455\InstantiationClassExists\Bar();
        }
    }
}
