<?php

namespace _PhpScoperbd5d0c5f7638\InnerFunctions;

function foo()
{
    function bar()
    {
    }
}
class Foo
{
    public function doFoo()
    {
        function anotherFoo()
        {
        }
    }
}
