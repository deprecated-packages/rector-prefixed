<?php

namespace _PhpScoperabd03f0baf05\ShadowedTraitMethod;

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
