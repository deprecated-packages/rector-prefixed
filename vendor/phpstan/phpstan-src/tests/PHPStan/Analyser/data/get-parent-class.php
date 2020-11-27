<?php

namespace _PhpScoperbd5d0c5f7638\ParentClass;

class Foo
{
    public function doFoo()
    {
        'inParentClass';
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\ParentClass\Foo
{
    use FooTrait;
    public function doBar()
    {
        'inChildClass';
    }
}
function (string $s) {
    die;
};
trait FooTrait
{
    public function doBaz()
    {
        'inTrait';
    }
}
