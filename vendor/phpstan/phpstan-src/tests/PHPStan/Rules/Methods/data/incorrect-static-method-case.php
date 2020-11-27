<?php

namespace _PhpScopera143bcca66cb\IncorrectStaticMethodCase;

class Foo
{
    public static function fooBar()
    {
        self::foobar();
        self::fooBar();
    }
}
