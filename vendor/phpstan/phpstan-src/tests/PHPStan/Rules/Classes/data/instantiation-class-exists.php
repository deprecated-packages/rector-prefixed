<?php

namespace _PhpScoperabd03f0baf05\InstantiationClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (\class_exists(\_PhpScoperabd03f0baf05\InstantiationClassExists\Bar::class)) {
            $bar = new \_PhpScoperabd03f0baf05\InstantiationClassExists\Bar();
        }
    }
}
