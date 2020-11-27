<?php

namespace _PhpScoper26e51eeacccf\ReturnStaticStaticMethod;

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
class Bar extends \_PhpScoper26e51eeacccf\ReturnStaticStaticMethod\Foo
{
    public function doBar()
    {
        self::doFoo()::doFoo()::doBar();
        self::doFoo()::doFoo()::doBaz();
    }
}
