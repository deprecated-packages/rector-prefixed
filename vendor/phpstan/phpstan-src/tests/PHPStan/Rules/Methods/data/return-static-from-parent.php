<?php

namespace _PhpScopera143bcca66cb\ReturnStaticFromParent;

class Foo
{
    /**
     * @return static
     */
    public function doFoo() : self
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\ReturnStaticFromParent\Foo
{
}
class Baz extends \_PhpScopera143bcca66cb\ReturnStaticFromParent\Bar
{
    public function doBaz() : self
    {
        $baz = $this->doFoo();
        return $baz;
    }
}
