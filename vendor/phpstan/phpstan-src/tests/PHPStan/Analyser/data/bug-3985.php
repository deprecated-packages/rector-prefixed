<?php

namespace _PhpScoper006a73f0e455\Bug3985;

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
