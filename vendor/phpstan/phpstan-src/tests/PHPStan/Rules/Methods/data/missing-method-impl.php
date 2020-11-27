<?php

namespace _PhpScoper006a73f0e455\MissingMethodImpl;

interface Foo
{
    public function doFoo();
}
abstract class Bar implements \_PhpScoper006a73f0e455\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
class Baz implements \_PhpScoper006a73f0e455\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
interface Lorem extends \_PhpScoper006a73f0e455\MissingMethodImpl\Foo
{
}
new class implements \_PhpScoper006a73f0e455\MissingMethodImpl\Foo
{
};
