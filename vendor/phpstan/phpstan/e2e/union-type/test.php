<?php

namespace RectorPrefix20210504\NativeUnionTypes;

class Foo
{
    public int|bool $fooProp;
    public function doFoo(int|bool $foo) : self|Bar
    {
        return new \RectorPrefix20210504\NativeUnionTypes\Foo();
    }
}
class Bar
{
}
