<?php

namespace _PhpScoper88fe6e0ad041\AnonymousClassWithInheritedConstructor;

class Foo
{
    public function __construct(int $i, int $j)
    {
        echo $i;
        echo $j;
    }
}
function () {
    new class(1, 2) extends \_PhpScoper88fe6e0ad041\AnonymousClassWithInheritedConstructor\Foo
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
    new class(1, 2) extends \_PhpScoper88fe6e0ad041\AnonymousClassWithInheritedConstructor\Bar
    {
    };
};
