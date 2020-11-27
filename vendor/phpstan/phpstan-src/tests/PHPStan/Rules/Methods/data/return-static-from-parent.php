<?php

namespace _PhpScoper88fe6e0ad041\ReturnStaticFromParent;

class Foo
{
    /**
     * @return static
     */
    public function doFoo() : self
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\ReturnStaticFromParent\Foo
{
}
class Baz extends \_PhpScoper88fe6e0ad041\ReturnStaticFromParent\Bar
{
    public function doBaz() : self
    {
        $baz = $this->doFoo();
        return $baz;
    }
}
