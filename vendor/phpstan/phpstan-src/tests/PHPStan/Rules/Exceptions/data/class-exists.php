<?php

namespace _PhpScopera143bcca66cb\CaughtExceptionClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\_PhpScopera143bcca66cb\CaughtExceptionClassExists\FooException::class)) {
            return;
        }
        try {
        } catch (\_PhpScopera143bcca66cb\CaughtExceptionClassExists\FooException $e) {
        }
    }
}
