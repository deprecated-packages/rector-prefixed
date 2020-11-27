<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\UnusedPrivatePromotedProperty;

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
