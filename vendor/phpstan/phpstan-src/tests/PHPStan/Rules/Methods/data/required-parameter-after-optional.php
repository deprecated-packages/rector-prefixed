<?php

namespace _PhpScoperabd03f0baf05\RequiredAfterOptional;

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
