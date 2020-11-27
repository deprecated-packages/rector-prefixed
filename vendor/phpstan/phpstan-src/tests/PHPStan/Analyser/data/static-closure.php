<?php

namespace _PhpScoperbd5d0c5f7638\StaticClosure;

class Foo
{
    public function doFoo() : void
    {
        static function () {
            die;
        };
    }
}
