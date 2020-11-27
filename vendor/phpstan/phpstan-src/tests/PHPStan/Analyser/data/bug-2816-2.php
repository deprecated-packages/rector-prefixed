<?php

namespace _PhpScopera143bcca66cb\Bug2816;

use PHPStan\TrinaryLogic;
use function PHPStan\Analyser\assertType;
use function PHPStan\Analyser\assertVariableCertainty;
if (isset($_GET['x'])) {
    $a = 1;
}
\PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
\PHPStan\Analyser\assertType('mixed', $a);
if (isset($a)) {
    echo "hello";
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
    \PHPStan\Analyser\assertType('mixed~null', $a);
} else {
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
}
\PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
\PHPStan\Analyser\assertType('mixed', $a);
if (isset($a)) {
    echo "hello2";
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
    \PHPStan\Analyser\assertType('mixed~null', $a);
} else {
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
}
\PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
\PHPStan\Analyser\assertType('mixed', $a);
