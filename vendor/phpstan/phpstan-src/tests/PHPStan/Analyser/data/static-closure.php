<?php

namespace _PhpScoperabd03f0baf05\StaticClosure;

class Foo
{
    public function doFoo() : void
    {
        static function () {
            die;
        };
    }
}
