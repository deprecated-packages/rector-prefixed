<?php

namespace _PhpScoper88fe6e0ad041\CallParentAbstractMethod;

interface Baz
{
    public function uninstall() : void;
}
abstract class Foo implements \_PhpScoper88fe6e0ad041\CallParentAbstractMethod\Baz
{
}
class Bar extends \_PhpScoper88fe6e0ad041\CallParentAbstractMethod\Foo
{
    public function uninstall() : void
    {
        parent::uninstall();
    }
}
abstract class Lorem
{
    public abstract function doFoo() : void;
}
class Ipsum extends \_PhpScoper88fe6e0ad041\CallParentAbstractMethod\Lorem
{
    public function doFoo() : void
    {
        parent::doFoo();
    }
}
abstract class Dolor extends \_PhpScoper88fe6e0ad041\CallParentAbstractMethod\Lorem
{
    public function doBar() : void
    {
        parent::doFoo();
    }
}
abstract class SitAmet
{
    static abstract function doFoo() : void;
}
function () : void {
    \_PhpScoper88fe6e0ad041\CallParentAbstractMethod\SitAmet::doFoo();
};
abstract class Consecteur
{
    public function doFoo()
    {
        static::doBar();
    }
    public abstract function doBar() : void;
}
