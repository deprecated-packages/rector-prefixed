<?php

namespace _PhpScopera143bcca66cb\InstanceofClassExists;

class Foo
{
    public function doFoo() : void
    {
        /** @var object $object */
        $object = doFoo();
        \class_exists(\_PhpScopera143bcca66cb\InstanceofClassExists\Bar::class) ? $object instanceof \_PhpScopera143bcca66cb\InstanceofClassExists\Bar : \false;
    }
}
