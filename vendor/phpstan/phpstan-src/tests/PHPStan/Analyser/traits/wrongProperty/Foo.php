<?php

namespace _PhpScoperbd5d0c5f7638\TraitsWrongProperty;

use _PhpScoperbd5d0c5f7638\Lorem as Bar;
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
