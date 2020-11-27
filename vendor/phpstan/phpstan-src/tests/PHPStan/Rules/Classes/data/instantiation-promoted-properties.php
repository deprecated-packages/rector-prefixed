<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\InstantiationPromotedProperties;

class Foo
{
    public function __construct(
        private array $foo,
        /** @var array<string> */
        private array $bar
    )
    {
    }
}
class Bar
{
    /**
     * @param array<string> $bar
     */
    public function __construct(private array $foo, private array $bar)
    {
    }
}
function () {
    new \_PhpScopera143bcca66cb\InstantiationPromotedProperties\Foo([], ['foo']);
    new \_PhpScopera143bcca66cb\InstantiationPromotedProperties\Foo([], [1]);
    new \_PhpScopera143bcca66cb\InstantiationPromotedProperties\Bar([], ['foo']);
    new \_PhpScopera143bcca66cb\InstantiationPromotedProperties\Bar([], [1]);
};
