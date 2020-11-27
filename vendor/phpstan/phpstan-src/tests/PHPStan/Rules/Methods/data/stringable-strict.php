<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\TestStringables;

class Dolor
{
    public function doFoo(string $s) : void
    {
    }
    public function doBar() : void
    {
        $this->doFoo(new \_PhpScopera143bcca66cb\TestStringables\Bar());
    }
}
