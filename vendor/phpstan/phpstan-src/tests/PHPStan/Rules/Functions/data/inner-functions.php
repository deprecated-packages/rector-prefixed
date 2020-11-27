<?php

namespace _PhpScoper26e51eeacccf\InnerFunctions;

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
