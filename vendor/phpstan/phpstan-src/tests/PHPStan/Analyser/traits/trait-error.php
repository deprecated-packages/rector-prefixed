<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\TraitErrors;

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
