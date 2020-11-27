<?php

namespace _PhpScoper26e51eeacccf\StaticCallOnExpression;

class Foo
{
    public static function doFoo() : self
    {
        return new static();
    }
}
function () {
    \_PhpScoper26e51eeacccf\StaticCallOnExpression\Foo::doFoo()::doBar();
};
