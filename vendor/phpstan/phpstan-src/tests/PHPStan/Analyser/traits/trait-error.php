<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\TraitErrors;

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
