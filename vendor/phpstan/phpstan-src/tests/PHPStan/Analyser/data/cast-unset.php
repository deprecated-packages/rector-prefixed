<?php

namespace _PhpScoper26e51eeacccf\TypesNamespaceCastUnset;

class Foo
{
    public function doFoo()
    {
        $castedNull = (unset) foo();
        die;
    }
}
