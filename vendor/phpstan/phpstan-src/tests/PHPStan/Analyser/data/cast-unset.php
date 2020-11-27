<?php

namespace _PhpScoperbd5d0c5f7638\TypesNamespaceCastUnset;

class Foo
{
    public function doFoo()
    {
        $castedNull = (unset) foo();
        die;
    }
}
