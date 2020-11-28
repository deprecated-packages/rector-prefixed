<?php

namespace _PhpScoperabd03f0baf05\EarlyTermination;

use PHPStan\TrinaryLogic;
use function PHPStan\Analyser\assertVariableCertainty;
function () : void {
    if (\rand(0, 1)) {
        \_PhpScoperabd03f0baf05\EarlyTermination\Foo::doBarPhpDoc();
    } else {
        $a = 1;
    }
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
};
function () : void {
    if (\rand(0, 1)) {
        (new \_PhpScoperabd03f0baf05\EarlyTermination\Foo())->doFooPhpDoc();
    } else {
        $a = 1;
    }
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
};
function () : void {
    if (\rand(0, 1)) {
        bazPhpDoc();
    } else {
        $a = 1;
    }
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
};
function () : void {
    if (\rand(0, 1)) {
        bazPhpDoc2();
    } else {
        $a = 1;
    }
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
};
