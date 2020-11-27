<?php

namespace _PhpScoper006a73f0e455\Bug3994;

class HelloWorld
{
    public function split(string $str) : void
    {
        $parts = \explode(".", $str);
        \assert(\count($parts) === 4);
    }
}
