<?php

namespace _PhpScoper88fe6e0ad041\Bug3990;

use PHPStan\TrinaryLogic;
use function PHPStan\Analyser\assertVariableCertainty;
function doFoo(array $config) : void
{
    \extract($config);
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
    if (isset($a)) {
        \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
    } else {
        \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
    }
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
}
