<?php

namespace _PhpScopera143bcca66cb\EarlyTermination;

use PHPStan\TrinaryLogic;
use function PHPStan\Analyser\assertVariableCertainty;
function () : void {
    if (\rand(0, 1)) {
        \_PhpScopera143bcca66cb\EarlyTermination\Foo::doBarPhpDoc();
    } else {
        $a = 1;
    }
    \PHPStan\Analyser\assertVariableCertainty(\PHPStan\TrinaryLogic::createYes(), $a);
};
function () : void {
    if (\rand(0, 1)) {
        (new \_PhpScopera143bcca66cb\EarlyTermination\Foo())->doFooPhpDoc();
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
