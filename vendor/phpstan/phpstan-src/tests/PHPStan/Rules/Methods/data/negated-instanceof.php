<?php

namespace _PhpScopera143bcca66cb\CallMethodAfterNegatedInstanceof;

class Foo
{
    public function doFoo()
    {
        $foo = new \stdClass();
        if (!$foo instanceof self || $foo->doFoo()) {
        }
    }
}
