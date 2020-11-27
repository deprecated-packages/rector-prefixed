<?php

namespace _PhpScoper006a73f0e455\Bug3445;

class Foo
{
    public function doFoo(self $test) : void
    {
    }
    public function doBar($test = \_PhpScoper006a73f0e455\Bug3445\UnknownClass::BAR) : void
    {
    }
}
class Bar
{
    public function doFoo(\_PhpScoper006a73f0e455\Bug3445\Foo $foo)
    {
        $foo->doFoo(new \_PhpScoper006a73f0e455\Bug3445\Foo());
        $foo->doFoo($this);
        $foo->doBar(new \stdClass());
    }
}
