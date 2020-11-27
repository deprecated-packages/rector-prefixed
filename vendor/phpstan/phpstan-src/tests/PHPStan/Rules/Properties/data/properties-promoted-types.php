<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\PromotedPropertiesExistingClasses;

class Foo
{
    public function __construct(
        public \stdClass $foo,
        /** @var \stdClass */
        public $bar,
        public \_PhpScoperbd5d0c5f7638\PromotedPropertiesExistingClasses\SomeTrait $baz,
        /** @var SomeTrait */
        public $lorem,
        public \_PhpScoperbd5d0c5f7638\PromotedPropertiesExistingClasses\Bar $ipsum,
        /** @var Bar */
        public $dolor
    )
    {
    }
}
trait SomeTrait
{
}
