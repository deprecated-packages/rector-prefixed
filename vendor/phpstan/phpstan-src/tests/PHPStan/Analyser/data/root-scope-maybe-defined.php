<?php

namespace _PhpScoperbd5d0c5f7638;

use PHPStan\TrinaryLogic;
\PHPStan\Analyser\assertType('mixed', $foo);
\PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $foo);
$bar = 'str';
\PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $bar);
\PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $baz);
\PHPStan\Analyser\assertType('\'str\'', $bar);
if (!isset($baz)) {
    $baz = 1;
    \PHPStan\Analyser\assertType('1', $baz);
}
\PHPStan\Analyser\assertType('mixed', $baz);
function () {
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createNo(), $foo);
};
