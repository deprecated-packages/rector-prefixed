<?php

namespace _PhpScoperbd5d0c5f7638\ShadowedTraitMethod;

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
