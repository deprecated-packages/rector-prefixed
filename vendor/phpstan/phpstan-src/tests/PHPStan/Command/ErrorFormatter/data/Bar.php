<?php

namespace _PhpScoper26e51eeacccf\BaselineIntegration;

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
