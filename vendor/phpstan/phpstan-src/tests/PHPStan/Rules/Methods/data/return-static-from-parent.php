<?php

namespace _PhpScoperabd03f0baf05\ReturnStaticFromParent;

class Foo
{
    /**
     * @return static
     */
    public function doFoo() : self
    {
    }
}
class Bar extends \_PhpScoperabd03f0baf05\ReturnStaticFromParent\Foo
{
}
class Baz extends \_PhpScoperabd03f0baf05\ReturnStaticFromParent\Bar
{
    public function doBaz() : self
    {
        $baz = $this->doFoo();
        return $baz;
    }
}
