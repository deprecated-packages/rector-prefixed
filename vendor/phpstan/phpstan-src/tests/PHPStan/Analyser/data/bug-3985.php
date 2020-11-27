<?php

namespace _PhpScoper88fe6e0ad041\Bug3985;

use PHPStan\TrinaryLogic;
use function PHPStan\Analyser\assertVariableCertainty;
class Foo
{
    public function doFoo(array $array) : void
    {
        foreach ($array as $val) {
            if (isset($foo[1])) {
                \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createNo(), $foo);
            }
        }
    }
    public function doBar() : void
    {
        if (isset($foo[1])) {
            \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createNo(), $foo);
        }
    }
}