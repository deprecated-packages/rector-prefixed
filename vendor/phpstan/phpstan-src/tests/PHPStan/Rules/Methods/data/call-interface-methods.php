<?php

namespace _PhpScoper006a73f0e455\InterfaceMethods;

interface Foo
{
    public function fooMethod();
    public static function fooStaticMethod();
}
abstract class Bar implements \_PhpScoper006a73f0e455\InterfaceMethods\Foo
{
}
abstract class Baz extends \_PhpScoper006a73f0e455\InterfaceMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->barMethod();
        self::fooStaticMethod();
        self::barStaticMethod();
    }
}
