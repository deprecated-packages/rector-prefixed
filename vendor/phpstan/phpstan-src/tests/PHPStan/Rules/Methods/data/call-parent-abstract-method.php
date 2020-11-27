<?php

namespace _PhpScopera143bcca66cb\CallParentAbstractMethod;

interface Baz
{
    public function uninstall() : void;
}
abstract class Foo implements \_PhpScopera143bcca66cb\CallParentAbstractMethod\Baz
{
}
class Bar extends \_PhpScopera143bcca66cb\CallParentAbstractMethod\Foo
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
class Ipsum extends \_PhpScopera143bcca66cb\CallParentAbstractMethod\Lorem
{
    public function doFoo() : void
    {
        parent::doFoo();
    }
}
abstract class Dolor extends \_PhpScopera143bcca66cb\CallParentAbstractMethod\Lorem
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
    \_PhpScopera143bcca66cb\CallParentAbstractMethod\SitAmet::doFoo();
};
abstract class Consecteur
{
    public function doFoo()
    {
        static::doBar();
    }
    public abstract function doBar() : void;
}
