<?php

namespace _PhpScoper26e51eeacccf\AnonymousClassWithInheritedConstructor;

class Foo
{
    public function __construct(int $i, int $j)
    {
        echo $i;
        echo $j;
    }
}
function () {
    new class(1, 2) extends \_PhpScoper26e51eeacccf\AnonymousClassWithInheritedConstructor\Foo
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
    new class(1, 2) extends \_PhpScoper26e51eeacccf\AnonymousClassWithInheritedConstructor\Bar
    {
    };
};
