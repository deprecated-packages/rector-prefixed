<?php

namespace _PhpScoper006a73f0e455\Bug2964;

class Foo
{
    public function doFoo(string $value)
    {
        if (\is_numeric($value)) {
            return $value * 1024;
        }
    }
}
