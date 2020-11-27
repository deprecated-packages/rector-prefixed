<?php

namespace _PhpScoperbd5d0c5f7638\InstantiationClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (\class_exists(\_PhpScoperbd5d0c5f7638\InstantiationClassExists\Bar::class)) {
            $bar = new \_PhpScoperbd5d0c5f7638\InstantiationClassExists\Bar();
        }
    }
}
