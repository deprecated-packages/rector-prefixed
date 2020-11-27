<?php

namespace _PhpScoperbd5d0c5f7638\StaticCallOnExpression;

class Foo
{
    public static function doFoo() : self
    {
        return new static();
    }
}
function () {
    \_PhpScoperbd5d0c5f7638\StaticCallOnExpression\Foo::doFoo()::doBar();
};
