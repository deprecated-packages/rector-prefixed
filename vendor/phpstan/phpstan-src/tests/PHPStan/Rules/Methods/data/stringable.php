<?php

namespace _PhpScoperabd03f0baf05\TestStringables;

use Stringable;
class Foo
{
    public function __toString() : string
    {
        return 'foo';
    }
}
class Bar implements \Stringable
{
    public function __toString() : string
    {
        return 'foo';
    }
}
interface Lorem extends \Stringable
{
}
class Baz
{
    public function doFoo(\Stringable $s) : void
    {
    }
    public function doBar(\_PhpScoperabd03f0baf05\TestStringables\Lorem $l) : void
    {
        $this->doFoo(new \_PhpScoperabd03f0baf05\TestStringables\Foo());
        $this->doFoo(new \_PhpScoperabd03f0baf05\TestStringables\Bar());
        $this->doFoo($l);
        $this->doBaz($l);
    }
    public function doBaz(string $s) : void
    {
    }
}
