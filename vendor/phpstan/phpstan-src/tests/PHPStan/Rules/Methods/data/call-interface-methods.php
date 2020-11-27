<?php

namespace _PhpScoper26e51eeacccf\InterfaceMethods;

interface Foo
{
    public function fooMethod();
    public static function fooStaticMethod();
}
abstract class Bar implements \_PhpScoper26e51eeacccf\InterfaceMethods\Foo
{
}
abstract class Baz extends \_PhpScoper26e51eeacccf\InterfaceMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->barMethod();
        self::fooStaticMethod();
        self::barStaticMethod();
    }
}
