<?php

namespace _PhpScoper88fe6e0ad041\GlobalVariables;

class Foo
{
    public function doFoo()
    {
        global $foo, $bar;
        echo $foo;
        echo $bar;
    }
}
