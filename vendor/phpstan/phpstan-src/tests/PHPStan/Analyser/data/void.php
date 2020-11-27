<?php

namespace _PhpScoperbd5d0c5f7638\VoidNamespace;

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
