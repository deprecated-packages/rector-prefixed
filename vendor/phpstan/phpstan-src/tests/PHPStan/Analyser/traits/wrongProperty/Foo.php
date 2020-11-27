<?php

namespace _PhpScoper88fe6e0ad041\TraitsWrongProperty;

use _PhpScoper88fe6e0ad041\Lorem as Bar;
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
