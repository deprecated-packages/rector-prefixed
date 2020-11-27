<?php

// lint >= 8.0
namespace _PhpScoper88fe6e0ad041\InstantiationPromotedProperties;

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
    new \_PhpScoper88fe6e0ad041\InstantiationPromotedProperties\Foo([], ['foo']);
    new \_PhpScoper88fe6e0ad041\InstantiationPromotedProperties\Foo([], [1]);
    new \_PhpScoper88fe6e0ad041\InstantiationPromotedProperties\Bar([], ['foo']);
    new \_PhpScoper88fe6e0ad041\InstantiationPromotedProperties\Bar([], [1]);
};
