<?php

// lint >= 8.0
namespace _PhpScoper26e51eeacccf\InstantiationPromotedProperties;

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
    new \_PhpScoper26e51eeacccf\InstantiationPromotedProperties\Foo([], ['foo']);
    new \_PhpScoper26e51eeacccf\InstantiationPromotedProperties\Foo([], [1]);
    new \_PhpScoper26e51eeacccf\InstantiationPromotedProperties\Bar([], ['foo']);
    new \_PhpScoper26e51eeacccf\InstantiationPromotedProperties\Bar([], [1]);
};
