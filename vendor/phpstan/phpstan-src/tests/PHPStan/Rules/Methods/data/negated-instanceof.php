<?php

namespace _PhpScoper88fe6e0ad041\CallMethodAfterNegatedInstanceof;

class Foo
{
    public function doFoo()
    {
        $foo = new \stdClass();
        if (!$foo instanceof self || $foo->doFoo()) {
        }
    }
}
