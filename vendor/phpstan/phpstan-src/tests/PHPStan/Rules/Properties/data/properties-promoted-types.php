<?php

// lint >= 8.0
namespace _PhpScoper88fe6e0ad041\PromotedPropertiesExistingClasses;

class Foo
{
    public function __construct(
        public \stdClass $foo,
        /** @var \stdClass */
        public $bar,
        public \_PhpScoper88fe6e0ad041\PromotedPropertiesExistingClasses\SomeTrait $baz,
        /** @var SomeTrait */
        public $lorem,
        public \_PhpScoper88fe6e0ad041\PromotedPropertiesExistingClasses\Bar $ipsum,
        /** @var Bar */
        public $dolor
    )
    {
    }
}
trait SomeTrait
{
}
