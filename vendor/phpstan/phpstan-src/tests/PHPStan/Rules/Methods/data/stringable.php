<?php

namespace _PhpScoper88fe6e0ad041\TestStringables;

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
    public function doBar(\_PhpScoper88fe6e0ad041\TestStringables\Lorem $l) : void
    {
        $this->doFoo(new \_PhpScoper88fe6e0ad041\TestStringables\Foo());
        $this->doFoo(new \_PhpScoper88fe6e0ad041\TestStringables\Bar());
        $this->doFoo($l);
        $this->doBaz($l);
    }
    public function doBaz(string $s) : void
    {
    }
}
