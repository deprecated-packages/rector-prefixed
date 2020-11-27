<?php

namespace _PhpScopera143bcca66cb\AccessPropertiesClassExists;

use function class_exists;
class Foo
{
    /** @var Bar|Baz */
    private $union;
    public function doFoo() : void
    {
        echo $this->union->lorem;
        if (\class_exists(\_PhpScopera143bcca66cb\AccessPropertiesClassExists\Bar::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\_PhpScopera143bcca66cb\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\_PhpScopera143bcca66cb\AccessPropertiesClassExists\Bar::class) && \class_exists(\_PhpScopera143bcca66cb\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
    }
    public function doBar($arg) : void
    {
        if (\class_exists(\_PhpScopera143bcca66cb\AccessPropertiesClassExists\Bar::class) && \class_exists(\_PhpScopera143bcca66cb\AccessPropertiesClassExists\Baz::class)) {
            if (\is_int($arg->foo)) {
                echo $this->union->lorem;
            }
        }
    }
}
