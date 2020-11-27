<?php

namespace _PhpScoperbd5d0c5f7638\Levels\MissingReturn;

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
