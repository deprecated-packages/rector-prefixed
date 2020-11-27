<?php

namespace _PhpScoper006a73f0e455\AccessPropertiesClassExists;

use function class_exists;
class Foo
{
    /** @var Bar|Baz */
    private $union;
    public function doFoo() : void
    {
        echo $this->union->lorem;
        if (\class_exists(\_PhpScoper006a73f0e455\AccessPropertiesClassExists\Bar::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\_PhpScoper006a73f0e455\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
        if (\class_exists(\_PhpScoper006a73f0e455\AccessPropertiesClassExists\Bar::class) && \class_exists(\_PhpScoper006a73f0e455\AccessPropertiesClassExists\Baz::class)) {
            echo $this->union->lorem;
        }
    }
    public function doBar($arg) : void
    {
        if (\class_exists(\_PhpScoper006a73f0e455\AccessPropertiesClassExists\Bar::class) && \class_exists(\_PhpScoper006a73f0e455\AccessPropertiesClassExists\Baz::class)) {
            if (\is_int($arg->foo)) {
                echo $this->union->lorem;
            }
        }
    }
}
