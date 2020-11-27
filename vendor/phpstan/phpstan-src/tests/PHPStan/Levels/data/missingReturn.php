<?php

namespace _PhpScoper006a73f0e455\Levels\MissingReturn;

class Foo
{
    public function doFoo() : int
    {
    }
    /**
     * @return int
     */
    public function doBar()
    {
    }
    /**
     * @return mixed
     */
    public function doBaz()
    {
    }
}
