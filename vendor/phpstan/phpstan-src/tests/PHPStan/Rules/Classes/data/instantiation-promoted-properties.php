<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\InstantiationPromotedProperties;

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
    new \_PhpScoper006a73f0e455\InstantiationPromotedProperties\Foo([], ['foo']);
    new \_PhpScoper006a73f0e455\InstantiationPromotedProperties\Foo([], [1]);
    new \_PhpScoper006a73f0e455\InstantiationPromotedProperties\Bar([], ['foo']);
    new \_PhpScoper006a73f0e455\InstantiationPromotedProperties\Bar([], [1]);
};
