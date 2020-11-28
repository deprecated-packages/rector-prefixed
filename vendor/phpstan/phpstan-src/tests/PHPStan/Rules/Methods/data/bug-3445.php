<?php

namespace _PhpScoperabd03f0baf05\Bug3445;

class Foo
{
    public function doFoo(self $test) : void
    {
    }
    public function doBar($test = \_PhpScoperabd03f0baf05\Bug3445\UnknownClass::BAR) : void
    {
    }
}
class Bar
{
    public function doFoo(\_PhpScoperabd03f0baf05\Bug3445\Foo $foo)
    {
        $foo->doFoo(new \_PhpScoperabd03f0baf05\Bug3445\Foo());
        $foo->doFoo($this);
        $foo->doBar(new \stdClass());
    }
}
