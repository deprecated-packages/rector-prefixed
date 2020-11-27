<?php

namespace _PhpScoperbd5d0c5f7638\InterfaceMethods;

interface Foo
{
    public function fooMethod();
    public static function fooStaticMethod();
}
abstract class Bar implements \_PhpScoperbd5d0c5f7638\InterfaceMethods\Foo
{
}
abstract class Baz extends \_PhpScoperbd5d0c5f7638\InterfaceMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->barMethod();
        self::fooStaticMethod();
        self::barStaticMethod();
    }
}
