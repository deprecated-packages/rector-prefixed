<?php

namespace _PhpScoperbd5d0c5f7638\CallMethodsWithoutUnionTypes;

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
