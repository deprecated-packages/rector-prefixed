<?php

namespace _PhpScoper26e51eeacccf\StaticClosure;

class Foo
{
    public function doFoo() : void
    {
        static function () {
            die;
        };
    }
}
