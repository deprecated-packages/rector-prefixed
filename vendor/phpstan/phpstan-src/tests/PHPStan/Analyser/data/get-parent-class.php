<?php

namespace _PhpScoper88fe6e0ad041\ParentClass;

class Foo
{
    public function doFoo()
    {
        'inParentClass';
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\ParentClass\Foo
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
