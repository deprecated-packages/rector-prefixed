<?php

namespace _PhpScopera143bcca66cb\TestStringables;

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
    public function doBar(\_PhpScopera143bcca66cb\TestStringables\Lorem $l) : void
    {
        $this->doFoo(new \_PhpScopera143bcca66cb\TestStringables\Foo());
        $this->doFoo(new \_PhpScopera143bcca66cb\TestStringables\Bar());
        $this->doFoo($l);
        $this->doBaz($l);
    }
    public function doBaz(string $s) : void
    {
    }
}
