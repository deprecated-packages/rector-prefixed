<?php

namespace _PhpScoper006a73f0e455\InstanceofClassExists;

class Foo
{
    public function doFoo() : void
    {
        /** @var object $object */
        $object = doFoo();
        \class_exists(\_PhpScoper006a73f0e455\InstanceofClassExists\Bar::class) ? $object instanceof \_PhpScoper006a73f0e455\InstanceofClassExists\Bar : \false;
    }
}
