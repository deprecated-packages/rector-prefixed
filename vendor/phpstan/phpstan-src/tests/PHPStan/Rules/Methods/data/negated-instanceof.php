<?php

namespace _PhpScoper006a73f0e455\CallMethodAfterNegatedInstanceof;

class Foo
{
    public function doFoo()
    {
        $foo = new \stdClass();
        if (!$foo instanceof self || $foo->doFoo()) {
        }
    }
}
