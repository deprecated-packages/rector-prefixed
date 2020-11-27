<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\UnusedPrivatePromotedProperty;

class Foo
{
    public function __construct(
        public $foo,
        protected $bar,
        private $baz,
        private $lorem,
        /** @get */
        private $ipsum
    )
    {
    }
    public function getBaz()
    {
        return $this->baz;
    }
}
