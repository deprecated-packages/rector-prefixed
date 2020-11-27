<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\PromotedPropertiesExistingClasses;

class Foo
{
    public function __construct(
        public \stdClass $foo,
        /** @var \stdClass */
        public $bar,
        public \_PhpScoper006a73f0e455\PromotedPropertiesExistingClasses\SomeTrait $baz,
        /** @var SomeTrait */
        public $lorem,
        public \_PhpScoper006a73f0e455\PromotedPropertiesExistingClasses\Bar $ipsum,
        /** @var Bar */
        public $dolor
    )
    {
    }
}
trait SomeTrait
{
}
