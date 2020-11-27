<?php

namespace _PhpScopera143bcca66cb\VoidNamespace;

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
