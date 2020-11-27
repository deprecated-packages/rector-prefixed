<?php

namespace _PhpScoper88fe6e0ad041\ShadowedTraitMethod;

trait FooTrait
{
    public function doFoo()
    {
        $this->doBar();
    }
}
class Foo
{
    use FooTrait;
    public function doFoo()
    {
    }
}
