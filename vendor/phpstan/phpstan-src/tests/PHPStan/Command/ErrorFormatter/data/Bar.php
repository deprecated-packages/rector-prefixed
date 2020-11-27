<?php

namespace _PhpScoper006a73f0e455\BaselineIntegration;

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
