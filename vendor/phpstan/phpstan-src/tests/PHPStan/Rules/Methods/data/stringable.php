<?php

namespace _PhpScoper26e51eeacccf\TestStringables;

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
    public function doBar(\_PhpScoper26e51eeacccf\TestStringables\Lorem $l) : void
    {
        $this->doFoo(new \_PhpScoper26e51eeacccf\TestStringables\Foo());
        $this->doFoo(new \_PhpScoper26e51eeacccf\TestStringables\Bar());
        $this->doFoo($l);
        $this->doBaz($l);
    }
    public function doBaz(string $s) : void
    {
    }
}
