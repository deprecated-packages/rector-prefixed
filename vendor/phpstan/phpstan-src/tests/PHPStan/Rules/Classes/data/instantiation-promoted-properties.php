<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\InstantiationPromotedProperties;

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
    new \_PhpScoperbd5d0c5f7638\InstantiationPromotedProperties\Foo([], ['foo']);
    new \_PhpScoperbd5d0c5f7638\InstantiationPromotedProperties\Foo([], [1]);
    new \_PhpScoperbd5d0c5f7638\InstantiationPromotedProperties\Bar([], ['foo']);
    new \_PhpScoperbd5d0c5f7638\InstantiationPromotedProperties\Bar([], [1]);
};
