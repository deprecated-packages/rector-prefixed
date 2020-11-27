<?php

namespace _PhpScoper88fe6e0ad041\CaughtExceptionClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoper88fe6e0ad041\CaughtExceptionClassExists\FooException::class)) {
            return;
        }
        try {
        } catch (\_PhpScoper88fe6e0ad041\CaughtExceptionClassExists\FooException $e) {
        }
    }
}
