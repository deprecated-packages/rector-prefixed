<?php

namespace _PhpScoperabd03f0baf05\CaughtExceptionClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoperabd03f0baf05\CaughtExceptionClassExists\FooException::class)) {
            return;
        }
        try {
        } catch (\_PhpScoperabd03f0baf05\CaughtExceptionClassExists\FooException $e) {
        }
    }
}
