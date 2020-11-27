<?php

namespace _PhpScoper88fe6e0ad041\ReturnStaticStaticMethod;

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
class Bar extends \_PhpScoper88fe6e0ad041\ReturnStaticStaticMethod\Foo
{
    public function doBar()
    {
        self::doFoo()::doFoo()::doBar();
        self::doFoo()::doFoo()::doBaz();
    }
}
