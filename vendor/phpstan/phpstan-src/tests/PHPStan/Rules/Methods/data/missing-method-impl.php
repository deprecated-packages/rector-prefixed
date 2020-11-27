<?php

namespace _PhpScoper26e51eeacccf\MissingMethodImpl;

interface Foo
{
    public function doFoo();
}
abstract class Bar implements \_PhpScoper26e51eeacccf\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
class Baz implements \_PhpScoper26e51eeacccf\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
interface Lorem extends \_PhpScoper26e51eeacccf\MissingMethodImpl\Foo
{
}
new class implements \_PhpScoper26e51eeacccf\MissingMethodImpl\Foo
{
};
