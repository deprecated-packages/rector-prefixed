<?php

namespace _PhpScoperabd03f0baf05\IncorrectStaticMethodCase;

class Foo
{
    public static function fooBar()
    {
        self::foobar();
        self::fooBar();
    }
}
