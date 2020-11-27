<?php

namespace _PhpScoper26e51eeacccf\Bug3445;

class Foo
{
    public function doFoo(self $test) : void
    {
    }
    public function doBar($test = \_PhpScoper26e51eeacccf\Bug3445\UnknownClass::BAR) : void
    {
    }
}
class Bar
{
    public function doFoo(\_PhpScoper26e51eeacccf\Bug3445\Foo $foo)
    {
        $foo->doFoo(new \_PhpScoper26e51eeacccf\Bug3445\Foo());
        $foo->doFoo($this);
        $foo->doBar(new \stdClass());
    }
}
