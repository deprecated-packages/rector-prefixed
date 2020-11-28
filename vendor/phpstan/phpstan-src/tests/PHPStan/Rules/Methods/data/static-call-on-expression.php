<?php

namespace _PhpScoperabd03f0baf05\StaticCallOnExpression;

class Foo
{
    public static function doFoo() : self
    {
        return new static();
    }
}
function () {
    \_PhpScoperabd03f0baf05\StaticCallOnExpression\Foo::doFoo()::doBar();
};
