<?php

namespace _PhpScoper88fe6e0ad041\InterfaceMethods;

interface Foo
{
    public function fooMethod();
    public static function fooStaticMethod();
}
abstract class Bar implements \_PhpScoper88fe6e0ad041\InterfaceMethods\Foo
{
}
abstract class Baz extends \_PhpScoper88fe6e0ad041\InterfaceMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->barMethod();
        self::fooStaticMethod();
        self::barStaticMethod();
    }
}
