<?php

namespace _PhpScoper006a73f0e455\StaticClosure;

class Foo
{
    public function doFoo() : void
    {
        static function () {
            die;
        };
    }
}
