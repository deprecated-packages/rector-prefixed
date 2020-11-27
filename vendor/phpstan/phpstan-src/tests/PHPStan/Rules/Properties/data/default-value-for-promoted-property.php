<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\DefaultValueForPromotedProperty;

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
