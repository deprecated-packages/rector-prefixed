<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\ParameterNotFoundTraitCrash;

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
