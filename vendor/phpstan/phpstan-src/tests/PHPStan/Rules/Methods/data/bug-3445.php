<?php

namespace _PhpScoperbd5d0c5f7638\Bug3445;

class Foo
{
    public function doFoo(self $test) : void
    {
    }
    public function doBar($test = \_PhpScoperbd5d0c5f7638\Bug3445\UnknownClass::BAR) : void
    {
    }
}
class Bar
{
    public function doFoo(\_PhpScoperbd5d0c5f7638\Bug3445\Foo $foo)
    {
        $foo->doFoo(new \_PhpScoperbd5d0c5f7638\Bug3445\Foo());
        $foo->doFoo($this);
        $foo->doBar(new \stdClass());
    }
}
