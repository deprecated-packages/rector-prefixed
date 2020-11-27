<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\TraitErrors;

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
