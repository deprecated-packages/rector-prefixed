<?php

namespace _PhpScopera143bcca66cb\ParentClass;

class Foo
{
    public function doFoo()
    {
        'inParentClass';
    }
}
class Bar extends \_PhpScopera143bcca66cb\ParentClass\Foo
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
