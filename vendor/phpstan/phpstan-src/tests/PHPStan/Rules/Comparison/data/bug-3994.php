<?php

namespace _PhpScoperabd03f0baf05\Bug3994;

class HelloWorld
{
    public function split(string $str) : void
    {
        $parts = \explode(".", $str);
        \assert(\count($parts) === 4);
    }
}
