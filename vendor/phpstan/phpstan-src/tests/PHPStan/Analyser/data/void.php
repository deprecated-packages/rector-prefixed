<?php

namespace _PhpScoper88fe6e0ad041\VoidNamespace;

class Foo
{
    public function doFoo() : void
    {
        die;
    }
    /**
     * @return void
     */
    public function doBar() : void
    {
    }
    /**
     * @return int
     */
    public function doConflictingVoid() : void
    {
    }
}
