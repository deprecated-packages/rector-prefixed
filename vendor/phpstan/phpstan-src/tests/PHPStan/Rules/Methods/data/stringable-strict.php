<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\TestStringables;

class Dolor
{
    public function doFoo(string $s) : void
    {
    }
    public function doBar() : void
    {
        $this->doFoo(new \_PhpScoperabd03f0baf05\TestStringables\Bar());
    }
}
