<?php

namespace _PhpScoperabd03f0baf05\CallMethodAfterNegatedInstanceof;

class Foo
{
    public function doFoo()
    {
        $foo = new \stdClass();
        if (!$foo instanceof self || $foo->doFoo()) {
        }
    }
}
