<?php

namespace _PhpScoper26e51eeacccf\InstanceofClassExists;

class Foo
{
    public function doFoo() : void
    {
        /** @var object $object */
        $object = doFoo();
        \class_exists(\_PhpScoper26e51eeacccf\InstanceofClassExists\Bar::class) ? $object instanceof \_PhpScoper26e51eeacccf\InstanceofClassExists\Bar : \false;
    }
}
