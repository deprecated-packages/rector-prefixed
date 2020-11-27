<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\InferPropertyType;

class Foo
{
    private $foo;
    private $bar;
    public function __construct(\DateTime $foo)
    {
        $this->foo = $foo;
        $this->bar = $this->bar;
    }
    public function doFoo()
    {
        $this->foo->formatt();
    }
}
