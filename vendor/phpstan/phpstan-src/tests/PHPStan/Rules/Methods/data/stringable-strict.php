<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\TestStringables;

class Dolor
{
    public function doFoo(string $s) : void
    {
    }
    public function doBar() : void
    {
        $this->doFoo(new \_PhpScoper006a73f0e455\TestStringables\Bar());
    }
}
