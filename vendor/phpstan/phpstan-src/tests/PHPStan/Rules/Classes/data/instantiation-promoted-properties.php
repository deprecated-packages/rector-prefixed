<?php

// lint >= 8.0
namespace _PhpScoperabd03f0baf05\InstantiationPromotedProperties;

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
    new \_PhpScoperabd03f0baf05\InstantiationPromotedProperties\Foo([], ['foo']);
    new \_PhpScoperabd03f0baf05\InstantiationPromotedProperties\Foo([], [1]);
    new \_PhpScoperabd03f0baf05\InstantiationPromotedProperties\Bar([], ['foo']);
    new \_PhpScoperabd03f0baf05\InstantiationPromotedProperties\Bar([], [1]);
};
