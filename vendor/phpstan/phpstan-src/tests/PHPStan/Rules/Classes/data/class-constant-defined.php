<?php

namespace _PhpScoperbd5d0c5f7638\ClassConstantNamespace;

class Foo
{
    const LOREM = 1;
    const IPSUM = 2;
    public function fooMethod()
    {
        self::class;
        self::LOREM;
        self::IPSUM;
    }
}
