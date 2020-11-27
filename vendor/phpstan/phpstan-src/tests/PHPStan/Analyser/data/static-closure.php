<?php

namespace _PhpScopera143bcca66cb\StaticClosure;

class Foo
{
    public function doFoo() : void
    {
        static function () {
            die;
        };
    }
}
