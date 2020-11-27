<?php

namespace _PhpScoperbd5d0c5f7638\TestStringables;

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
    public function doBar(\_PhpScoperbd5d0c5f7638\TestStringables\Lorem $l) : void
    {
        $this->doFoo(new \_PhpScoperbd5d0c5f7638\TestStringables\Foo());
        $this->doFoo(new \_PhpScoperbd5d0c5f7638\TestStringables\Bar());
        $this->doFoo($l);
        $this->doBaz($l);
    }
    public function doBaz(string $s) : void
    {
    }
}
