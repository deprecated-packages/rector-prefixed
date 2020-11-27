<?php

namespace _PhpScoperbd5d0c5f7638\AnonymousClassWithInheritedConstructor;

class Foo
{
    public function __construct(int $i, int $j)
    {
        echo $i;
        echo $j;
    }
}
function () {
    new class(1, 2) extends \_PhpScoperbd5d0c5f7638\AnonymousClassWithInheritedConstructor\Foo
    {
    };
};
class Bar
{
    public final function __construct(int $i, int $j)
    {
        echo $i;
        echo $j;
    }
}
function () {
    new class(1, 2) extends \_PhpScoperbd5d0c5f7638\AnonymousClassWithInheritedConstructor\Bar
    {
    };
};
