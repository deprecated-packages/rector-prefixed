<?php

namespace _PhpScoper88fe6e0ad041\Bug3445;

class Foo
{
    public function doFoo(self $test) : void
    {
    }
    public function doBar($test = \_PhpScoper88fe6e0ad041\Bug3445\UnknownClass::BAR) : void
    {
    }
}
class Bar
{
    public function doFoo(\_PhpScoper88fe6e0ad041\Bug3445\Foo $foo)
    {
        $foo->doFoo(new \_PhpScoper88fe6e0ad041\Bug3445\Foo());
        $foo->doFoo($this);
        $foo->doBar(new \stdClass());
    }
}
