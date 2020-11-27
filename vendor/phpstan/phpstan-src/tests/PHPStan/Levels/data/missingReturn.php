<?php

namespace _PhpScoper88fe6e0ad041\Levels\MissingReturn;

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
