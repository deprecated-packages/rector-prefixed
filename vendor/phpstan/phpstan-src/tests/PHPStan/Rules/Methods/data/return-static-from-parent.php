<?php

namespace _PhpScoperbd5d0c5f7638\ReturnStaticFromParent;

class Foo
{
    /**
     * @return static
     */
    public function doFoo() : self
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\ReturnStaticFromParent\Foo
{
}
class Baz extends \_PhpScoperbd5d0c5f7638\ReturnStaticFromParent\Bar
{
    public function doBaz() : self
    {
        $baz = $this->doFoo();
        return $baz;
    }
}
