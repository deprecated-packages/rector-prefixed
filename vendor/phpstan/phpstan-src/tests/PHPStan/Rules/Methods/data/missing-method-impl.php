<?php

namespace _PhpScoperabd03f0baf05\MissingMethodImpl;

interface Foo
{
    public function doFoo();
}
abstract class Bar implements \_PhpScoperabd03f0baf05\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
class Baz implements \_PhpScoperabd03f0baf05\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
interface Lorem extends \_PhpScoperabd03f0baf05\MissingMethodImpl\Foo
{
}
new class implements \_PhpScoperabd03f0baf05\MissingMethodImpl\Foo
{
};
