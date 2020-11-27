<?php

namespace _PhpScoper006a73f0e455\StaticCallOnExpression;

class Foo
{
    public static function doFoo() : self
    {
        return new static();
    }
}
function () {
    \_PhpScoper006a73f0e455\StaticCallOnExpression\Foo::doFoo()::doBar();
};
