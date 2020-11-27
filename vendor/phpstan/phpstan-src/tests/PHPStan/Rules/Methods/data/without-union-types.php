<?php

namespace _PhpScoper88fe6e0ad041\CallMethodsWithoutUnionTypes;

class Foo
{
    /** @var self|false */
    private $selfOrFalse;
    public function doFoo()
    {
        $this->selfOrFalse->doFoo();
        $this->selfOrFalse->doFoo(1, 2, 3);
    }
}
