<?php

namespace _PhpScoper006a73f0e455\AnonymousClassWithInheritedConstructor;

class Foo
{
    public function __construct(int $i, int $j)
    {
        echo $i;
        echo $j;
    }
}
function () {
    new class(1, 2) extends \_PhpScoper006a73f0e455\AnonymousClassWithInheritedConstructor\Foo
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
    new class(1, 2) extends \_PhpScoper006a73f0e455\AnonymousClassWithInheritedConstructor\Bar
    {
    };
};
