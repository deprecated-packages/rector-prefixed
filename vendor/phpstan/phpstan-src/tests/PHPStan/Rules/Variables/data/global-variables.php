<?php

namespace _PhpScoper006a73f0e455\GlobalVariables;

class Foo
{
    public function doFoo()
    {
        global $foo, $bar;
        echo $foo;
        echo $bar;
    }
}
