<?php

namespace _PhpScopera143bcca66cb\Bug2964;

class Foo
{
    public function doFoo(string $value)
    {
        if (\is_numeric($value)) {
            return $value * 1024;
        }
    }
}
