<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\InferPropertyType;

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
