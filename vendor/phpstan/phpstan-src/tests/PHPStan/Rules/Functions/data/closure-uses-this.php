<?php

namespace _PhpScoper006a73f0e455\ClosureUsesThis;

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
