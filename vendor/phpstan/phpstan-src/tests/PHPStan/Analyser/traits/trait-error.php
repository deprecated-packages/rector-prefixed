<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\TraitErrors;

trait MyTrait
{
    public function test() : void
    {
        echo $undefined;
        $this->undefined($undefined);
    }
}
class MyClass
{
    use MyTrait;
}
