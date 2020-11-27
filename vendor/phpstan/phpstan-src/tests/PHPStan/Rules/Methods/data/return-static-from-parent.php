<?php

namespace _PhpScoper006a73f0e455\ReturnStaticFromParent;

class Foo
{
    /**
     * @return static
     */
    public function doFoo() : self
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\ReturnStaticFromParent\Foo
{
}
class Baz extends \_PhpScoper006a73f0e455\ReturnStaticFromParent\Bar
{
    public function doBaz() : self
    {
        $baz = $this->doFoo();
        return $baz;
    }
}
