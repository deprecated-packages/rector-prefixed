<?php

namespace _PhpScoperbd5d0c5f7638\CaughtExceptionClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScoperbd5d0c5f7638\CaughtExceptionClassExists\FooException::class)) {
            return;
        }
        try {
        } catch (\_PhpScoperbd5d0c5f7638\CaughtExceptionClassExists\FooException $e) {
        }
    }
}
