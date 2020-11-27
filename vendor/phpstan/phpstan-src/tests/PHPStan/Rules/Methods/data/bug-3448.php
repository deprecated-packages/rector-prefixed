<?php

namespace _PhpScoperbd5d0c5f7638\Bug3448;

use function func_get_args;
final class Foo
{
    public static function add(int $lall) : void
    {
        $args = \func_get_args();
    }
}
final class UseFoo
{
    public static function do() : void
    {
        \_PhpScoperbd5d0c5f7638\Bug3448\Foo::add(1, [new \stdClass()]);
        \_PhpScoperbd5d0c5f7638\Bug3448\Foo::add('foo');
        \_PhpScoperbd5d0c5f7638\Bug3448\Foo::add('foo', [new \stdClass()]);
    }
}
