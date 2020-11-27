<?php

namespace _PhpScopera143bcca66cb\Bug3445;

class Foo
{
    public function doFoo(self $test) : void
    {
    }
    public function doBar($test = \_PhpScopera143bcca66cb\Bug3445\UnknownClass::BAR) : void
    {
    }
}
class Bar
{
    public function doFoo(\_PhpScopera143bcca66cb\Bug3445\Foo $foo)
    {
        $foo->doFoo(new \_PhpScopera143bcca66cb\Bug3445\Foo());
        $foo->doFoo($this);
        $foo->doBar(new \stdClass());
    }
}
