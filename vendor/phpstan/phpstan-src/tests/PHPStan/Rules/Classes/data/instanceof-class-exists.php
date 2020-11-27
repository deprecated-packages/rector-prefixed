<?php

namespace _PhpScoper88fe6e0ad041\InstanceofClassExists;

class Foo
{
    public function doFoo() : void
    {
        /** @var object $object */
        $object = doFoo();
        \class_exists(\_PhpScoper88fe6e0ad041\InstanceofClassExists\Bar::class) ? $object instanceof \_PhpScoper88fe6e0ad041\InstanceofClassExists\Bar : \false;
    }
}
