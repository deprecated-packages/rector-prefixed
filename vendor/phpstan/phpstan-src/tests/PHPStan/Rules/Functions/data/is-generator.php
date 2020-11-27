<?php

namespace _PhpScoper006a73f0e455\FunctionGeneratorReturn;

class Foo
{
}
if (\false) {
    function doBar(bool $skipThings) : iterable
    {
        if ($skipThings) {
            return;
        }
        (yield 1);
    }
    function doFoo(bool $skipThings) : iterable
    {
        if ($skipThings) {
            return;
        }
        yield from array();
    }
}
