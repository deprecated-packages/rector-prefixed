<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\PromotedPropertiesMissingTypehint;

class Foo
{
    /**
     * @param int $baz
     */
    public function __construct(
        private int $foo,
        /** @var int */
        private $bar,
        private $baz,
        private $lorem,
        private array $ipsum
    )
    {
    }
}
