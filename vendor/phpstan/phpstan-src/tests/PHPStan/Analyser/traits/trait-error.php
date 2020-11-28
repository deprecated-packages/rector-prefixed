<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\TraitErrors;

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
