<?php

namespace _PhpScoper26e51eeacccf\ReturnStaticFromParent;

class Foo
{
    /**
     * @return static
     */
    public function doFoo() : self
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\ReturnStaticFromParent\Foo
{
}
class Baz extends \_PhpScoper26e51eeacccf\ReturnStaticFromParent\Bar
{
    public function doBaz() : self
    {
        $baz = $this->doFoo();
        return $baz;
    }
}
