<?php

namespace _PhpScopera143bcca66cb\InterfaceMethods;

interface Foo
{
    public function fooMethod();
    public static function fooStaticMethod();
}
abstract class Bar implements \_PhpScopera143bcca66cb\InterfaceMethods\Foo
{
}
abstract class Baz extends \_PhpScopera143bcca66cb\InterfaceMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->barMethod();
        self::fooStaticMethod();
        self::barStaticMethod();
    }
}
