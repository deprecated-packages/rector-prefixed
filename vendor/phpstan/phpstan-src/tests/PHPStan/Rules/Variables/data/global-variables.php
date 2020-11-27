<?php

namespace _PhpScoperbd5d0c5f7638\GlobalVariables;

class Foo
{
    public function doFoo()
    {
        global $foo, $bar;
        echo $foo;
        echo $bar;
    }
}
