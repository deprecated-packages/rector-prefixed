<?php

namespace _PhpScopera143bcca66cb\GlobalVariables;

class Foo
{
    public function doFoo()
    {
        global $foo, $bar;
        echo $foo;
        echo $bar;
    }
}
