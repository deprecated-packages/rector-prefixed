<?php

namespace _PhpScopera143bcca66cb\BaselineIntegration;

class Bar
{
    use FooTrait;
    /**
     * @return array<array<int>>
     */
    public function doFoo() : array
    {
        return [['foo']];
    }
}
