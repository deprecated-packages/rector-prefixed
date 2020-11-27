<?php

namespace _PhpScoper88fe6e0ad041\MissingMethodImpl;

interface Foo
{
    public function doFoo();
}
abstract class Bar implements \_PhpScoper88fe6e0ad041\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
class Baz implements \_PhpScoper88fe6e0ad041\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
interface Lorem extends \_PhpScoper88fe6e0ad041\MissingMethodImpl\Foo
{
}
new class implements \_PhpScoper88fe6e0ad041\MissingMethodImpl\Foo
{
};
