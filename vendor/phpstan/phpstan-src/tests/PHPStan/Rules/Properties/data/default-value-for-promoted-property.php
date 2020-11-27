<?php

// lint >= 8.0
namespace _PhpScoper26e51eeacccf\DefaultValueForPromotedProperty;

class Foo
{
    public function __construct(
        private int $foo = 'foo',
        /** @var int */
        private $foo = '',
        private int $baz = 1
    )
    {
    }
}
