<?php

// lint >= 8.0
namespace _PhpScopera143bcca66cb\PromotedPropertiesExistingClasses;

class Foo
{
    public function __construct(
        public \stdClass $foo,
        /** @var \stdClass */
        public $bar,
        public \_PhpScopera143bcca66cb\PromotedPropertiesExistingClasses\SomeTrait $baz,
        /** @var SomeTrait */
        public $lorem,
        public \_PhpScopera143bcca66cb\PromotedPropertiesExistingClasses\Bar $ipsum,
        /** @var Bar */
        public $dolor
    )
    {
    }
}
trait SomeTrait
{
}
