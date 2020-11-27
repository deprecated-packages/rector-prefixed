<?php

namespace _PhpScoperbd5d0c5f7638\MissingMethodImpl;

interface Foo
{
    public function doFoo();
}
abstract class Bar implements \_PhpScoperbd5d0c5f7638\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
class Baz implements \_PhpScoperbd5d0c5f7638\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
interface Lorem extends \_PhpScoperbd5d0c5f7638\MissingMethodImpl\Foo
{
}
new class implements \_PhpScoperbd5d0c5f7638\MissingMethodImpl\Foo
{
};
