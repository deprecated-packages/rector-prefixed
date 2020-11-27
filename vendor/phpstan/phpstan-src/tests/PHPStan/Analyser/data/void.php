<?php

namespace _PhpScoper006a73f0e455\VoidNamespace;

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
