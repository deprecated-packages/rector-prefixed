<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\TestStringables;

class Dolor
{
    public function doFoo(string $s) : void
    {
    }
    public function doBar() : void
    {
        $this->doFoo(new \_PhpScoperbd5d0c5f7638\TestStringables\Bar());
    }
}
