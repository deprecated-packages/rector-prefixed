<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\TestStringables;

class Dolor
{
    public function doFoo(string $s) : void
    {
    }
    public function doBar() : void
    {
        $this->doFoo(new \_PhpScoper26e51eeacccf\TestStringables\Bar());
    }
}
