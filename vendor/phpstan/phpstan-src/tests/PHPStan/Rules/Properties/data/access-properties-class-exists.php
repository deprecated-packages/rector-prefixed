<?php

namespace _PhpScoper88fe6e0ad041\AccessPropertiesClassExists;

use function class_exists;
class Foo
{
    /** @var Bar|Baz */
    private $union;
    public function doFoo() : void
    {
        echo $this->union->lorem;
        if (\class_exists(\_PhpScoper88fe6e0ad041\AccessPropertiesClassExists\Bar::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\_PhpScoper88fe6e0ad041\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\_PhpScoper88fe6e0ad041\AccessPropertiesClassExists\Bar::class) && \class_exists(\_PhpScoper88fe6e0ad041\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
    }
    public function doBar($arg) : void
    {
        if (\class_exists(\_PhpScoper88fe6e0ad041\AccessPropertiesClassExists\Bar::class) && \class_exists(\_PhpScoper88fe6e0ad041\AccessPropertiesClassExists\Baz::class)) {
            if (\is_int($arg->foo)) {
                echo $this->union->lorem;
            }
        }
    }
}
