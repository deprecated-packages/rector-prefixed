<?php

namespace _PhpScoper006a73f0e455\ParentClass;

class Foo
{
    public function doFoo()
    {
        'inParentClass';
    }
}
class Bar extends \_PhpScoper006a73f0e455\ParentClass\Foo
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
