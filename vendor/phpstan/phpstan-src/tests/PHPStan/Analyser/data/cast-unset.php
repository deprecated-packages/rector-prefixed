<?php

namespace _PhpScoper006a73f0e455\TypesNamespaceCastUnset;

class Foo
{
    public function doFoo()
    {
        $castedNull = (unset) foo();
        die;
    }
}
