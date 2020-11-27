<?php

namespace _PhpScoper006a73f0e455\TraitsWrongProperty;

use _PhpScoper006a73f0e455\Lorem as Bar;
class Foo
{
    use FooTrait;
    public function doFoo() : void
    {
        $this->id = 1;
        $this->id = 'foo';
        $this->bar = 1;
    }
}
