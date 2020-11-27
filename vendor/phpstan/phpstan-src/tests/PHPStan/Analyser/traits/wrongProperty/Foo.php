<?php

namespace _PhpScoper26e51eeacccf\TraitsWrongProperty;

use _PhpScoper26e51eeacccf\Lorem as Bar;
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
