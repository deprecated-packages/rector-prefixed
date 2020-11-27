<?php

namespace _PhpScoperbd5d0c5f7638\InstanceofClassExists;

class Foo
{
    public function doFoo() : void
    {
        /** @var object $object */
        $object = doFoo();
        \class_exists(\_PhpScoperbd5d0c5f7638\InstanceofClassExists\Bar::class) ? $object instanceof \_PhpScoperbd5d0c5f7638\InstanceofClassExists\Bar : \false;
    }
}
