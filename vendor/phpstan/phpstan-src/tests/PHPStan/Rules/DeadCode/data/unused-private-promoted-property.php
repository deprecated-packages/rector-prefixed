<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\UnusedPrivatePromotedProperty;

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
