<?php

namespace _PhpScoper26e51eeacccf\InstantiationClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (\class_exists(\_PhpScoper26e51eeacccf\InstantiationClassExists\Bar::class)) {
            $bar = new \_PhpScoper26e51eeacccf\InstantiationClassExists\Bar();
        }
    }
}
