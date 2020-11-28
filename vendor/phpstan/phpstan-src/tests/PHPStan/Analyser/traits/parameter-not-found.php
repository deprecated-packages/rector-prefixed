<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\ParameterNotFoundTraitCrash;

trait ConstructorWithoutArgumentsTrait
{
    public function __construct()
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
    public function __construct(\stdClass $foo)
    {
        $this->foo = $foo;
    }
}
