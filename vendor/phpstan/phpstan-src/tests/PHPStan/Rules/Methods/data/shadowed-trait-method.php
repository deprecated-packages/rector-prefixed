<?php

namespace _PhpScoper006a73f0e455\ShadowedTraitMethod;

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
