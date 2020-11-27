<?php

namespace _PhpScoper26e51eeacccf\CaughtExceptionClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper26e51eeacccf\CaughtExceptionClassExists\FooException::class)) {
            return;
        }
        try {
        } catch (\_PhpScoper26e51eeacccf\CaughtExceptionClassExists\FooException $e) {
        }
    }
}
