<?php

namespace _PhpScopera143bcca66cb\MissingMethodImpl;

interface Foo
{
    public function doFoo();
}
abstract class Bar implements \_PhpScopera143bcca66cb\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
class Baz implements \_PhpScopera143bcca66cb\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
interface Lorem extends \_PhpScopera143bcca66cb\MissingMethodImpl\Foo
{
}
new class implements \_PhpScopera143bcca66cb\MissingMethodImpl\Foo
{
};
