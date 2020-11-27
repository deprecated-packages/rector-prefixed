<?php

namespace _PhpScopera143bcca66cb\CallMethodsWithoutUnionTypes;

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
