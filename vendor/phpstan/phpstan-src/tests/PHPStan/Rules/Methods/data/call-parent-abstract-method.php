<?php

namespace _PhpScoper006a73f0e455\CallParentAbstractMethod;

interface Baz
{
    public function uninstall() : void;
}
abstract class Foo implements \_PhpScoper006a73f0e455\CallParentAbstractMethod\Baz
{
}
class Bar extends \_PhpScoper006a73f0e455\CallParentAbstractMethod\Foo
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
class Ipsum extends \_PhpScoper006a73f0e455\CallParentAbstractMethod\Lorem
{
    public function doFoo() : void
    {
        parent::doFoo();
    }
}
abstract class Dolor extends \_PhpScoper006a73f0e455\CallParentAbstractMethod\Lorem
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
    \_PhpScoper006a73f0e455\CallParentAbstractMethod\SitAmet::doFoo();
};
abstract class Consecteur
{
    public function doFoo()
    {
        static::doBar();
    }
    public abstract function doBar() : void;
}
