<?php

namespace _PhpScoperabd03f0baf05\ReturnStaticStaticMethod;

class Foo
{
    /**
     * @return static
     */
    public static function doFoo() : self
    {
        return new static();
    }
}
class Bar extends \_PhpScoperabd03f0baf05\ReturnStaticStaticMethod\Foo
{
    public function doBar()
    {
        self::doFoo()::doFoo()::doBar();
        self::doFoo()::doFoo()::doBaz();
    }
}
