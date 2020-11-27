<?php

namespace _PhpScoper88fe6e0ad041\ClosureUsesThis;

class Foo
{
    public function doFoo()
    {
        $f = function () {
            // ok
        };
        $that = $this;
        $f = function () use($that) {
            // report
        };
        $f = static function () use($that) {
            // ok
        };
    }
}
