<?php

namespace _PhpScoper88fe6e0ad041\StaticCallOnExpression;

class Foo
{
    public static function doFoo() : self
    {
        return new static();
    }
}
function () {
    \_PhpScoper88fe6e0ad041\StaticCallOnExpression\Foo::doFoo()::doBar();
};
