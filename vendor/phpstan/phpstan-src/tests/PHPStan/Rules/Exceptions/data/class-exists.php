<?php

namespace _PhpScoper006a73f0e455\CaughtExceptionClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper006a73f0e455\CaughtExceptionClassExists\FooException::class)) {
            return;
        }
        try {
        } catch (\_PhpScoper006a73f0e455\CaughtExceptionClassExists\FooException $e) {
        }
    }
}
