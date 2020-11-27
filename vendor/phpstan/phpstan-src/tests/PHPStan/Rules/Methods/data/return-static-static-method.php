<?php

namespace _PhpScoperbd5d0c5f7638\ReturnStaticStaticMethod;

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
class Bar extends \_PhpScoperbd5d0c5f7638\ReturnStaticStaticMethod\Foo
{
    public function doBar()
    {
        self::doFoo()::doFoo()::doBar();
        self::doFoo()::doFoo()::doBaz();
    }
}
