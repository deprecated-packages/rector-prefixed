<?php

namespace _PhpScoper006a73f0e455\BugPr339;

use PHPStan\TrinaryLogic;
use function PHPStan\Analyser\assertType;
use function PHPStan\Analyser\assertVariableCertainty;
\PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
\PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $c);
\PHPStan\Analyser\assertType('mixed', $a);
\PHPStan\Analyser\assertType('mixed', $c);
if ($a || $c) {
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $a);
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createMaybe(), $c);
    \PHPStan\Analyser\assertType('mixed', $a);
    \PHPStan\Analyser\assertType('mixed', $c);
    if ($a) {
        \PHPStan\Analyser\assertType("mixed~0|0.0|''|'0'|array()|false|null", $a);
        \PHPStan\Analyser\assertType('mixed', $c);
        \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
    }
    if ($c) {
        \PHPStan\Analyser\assertType('mixed', $a);
        \PHPStan\Analyser\assertType("mixed~0|0.0|''|'0'|array()|false|null", $c);
        \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $c);
    }
} else {
    \PHPStan\Analyser\assertType("0|0.0|''|'0'|array()|false|null", $a);
    \PHPStan\Analyser\assertType("0|0.0|''|'0'|array()|false|null", $c);
}
