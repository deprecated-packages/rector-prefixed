<?php

namespace _PhpScoper88fe6e0ad041\BaselineIntegration;

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
