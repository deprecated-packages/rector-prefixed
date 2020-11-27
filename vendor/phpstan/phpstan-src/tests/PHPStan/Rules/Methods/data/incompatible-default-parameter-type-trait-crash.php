<?php

namespace _PhpScoper006a73f0e455\IncompatibleDefaultParameterTypeTraitCrash;

trait ConstructorWithoutArgumentsTrait
{
    public function __construct(\stdClass $foo = null)
    {
    }
}
class Foo
{
    use ConstructorWithoutArgumentsTrait;
    /**
     * @var \stdClass
     */
    protected $foo;
    public function __construct()
    {
    }
}
