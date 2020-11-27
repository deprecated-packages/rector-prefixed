<?php

namespace _PhpScopera143bcca66cb\StaticCallOnExpression;

class Foo
{
    public static function doFoo() : self
    {
        return new static();
    }
}
function () {
    \_PhpScopera143bcca66cb\StaticCallOnExpression\Foo::doFoo()::doBar();
};
