<?php

namespace _PhpScoperbd5d0c5f7638\IncorrectStaticMethodCase;

class Foo
{
    public static function fooBar()
    {
        self::foobar();
        self::fooBar();
    }
}
