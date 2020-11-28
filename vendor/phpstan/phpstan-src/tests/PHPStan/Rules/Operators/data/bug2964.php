<?php

namespace _PhpScoperabd03f0baf05\Bug2964;

class Foo
{
    public function doFoo(string $value)
    {
        if (\is_numeric($value)) {
            return $value * 1024;
        }
    }
}
