<?php

namespace _PhpScoper88fe6e0ad041\StaticClosure;

class Foo
{
    public function doFoo() : void
    {
        static function () {
            die;
        };
    }
}
