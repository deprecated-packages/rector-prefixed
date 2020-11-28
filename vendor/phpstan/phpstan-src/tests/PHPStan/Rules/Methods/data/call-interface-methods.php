<?php

namespace _PhpScoperabd03f0baf05\InterfaceMethods;

interface Foo
{
    public function fooMethod();
    public static function fooStaticMethod();
}
abstract class Bar implements \_PhpScoperabd03f0baf05\InterfaceMethods\Foo
{
}
abstract class Baz extends \_PhpScoperabd03f0baf05\InterfaceMethods\Bar
{
    public function bazMethod()
    {
        $this->fooMethod();
        $this->barMethod();
        self::fooStaticMethod();
        self::barStaticMethod();
    }
}
