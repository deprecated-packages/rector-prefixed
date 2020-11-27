<?php

namespace _PhpScoper006a73f0e455\RequiredAfterOptional;

class Foo
{
    public function doFoo($foo = null, $bar) : void
    {
    }
    public function doBar(int $foo = null, $bar) : void
    {
    }
    public function doBaz(int $foo = 1, $bar) : void
    {
    }
    public function doLorem(bool $foo = \true, $bar) : void
    {
    }
}
