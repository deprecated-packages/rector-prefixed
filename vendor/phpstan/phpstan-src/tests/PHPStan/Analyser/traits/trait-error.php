<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\TraitErrors;

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
