<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\TestStringables;

class Dolor
{
    public function doFoo(string $s) : void
    {
    }
    public function doBar() : void
    {
        $this->doFoo(new \_PhpScoper88fe6e0ad041\TestStringables\Bar());
    }
}
