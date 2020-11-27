<?php

namespace _PhpScoper26e51eeacccf\AccessPropertiesClassExists;

use function class_exists;
class Foo
{
    /** @var Bar|Baz */
    private $union;
    public function doFoo() : void
    {
        echo $this->union->lorem;
        if (\class_exists(\_PhpScoper26e51eeacccf\AccessPropertiesClassExists\Bar::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\_PhpScoper26e51eeacccf\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\_PhpScoper26e51eeacccf\AccessPropertiesClassExists\Bar::class) && \class_exists(\_PhpScoper26e51eeacccf\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
    }
    public function doBar($arg) : void
    {
        if (\class_exists(\_PhpScoper26e51eeacccf\AccessPropertiesClassExists\Bar::class) && \class_exists(\_PhpScoper26e51eeacccf\AccessPropertiesClassExists\Baz::class)) {
            if (\is_int($arg->foo)) {
                echo $this->union->lorem;
            }
        }
    }
}
