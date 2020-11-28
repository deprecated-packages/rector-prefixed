<?php

namespace _PhpScoperabd03f0baf05\TypesNamespaceCastUnset;

class Foo
{
    public function doFoo()
    {
        $castedNull = (unset) foo();
        die;
    }
}
