<?php

namespace _PhpScoperabd03f0baf05\InstanceofClassExists;

class Foo
{
    public function doFoo() : void
    {
        /** @var object $object */
        $object = doFoo();
        \class_exists(\_PhpScoperabd03f0baf05\InstanceofClassExists\Bar::class) ? $object instanceof \_PhpScoperabd03f0baf05\InstanceofClassExists\Bar : \false;
    }
}
