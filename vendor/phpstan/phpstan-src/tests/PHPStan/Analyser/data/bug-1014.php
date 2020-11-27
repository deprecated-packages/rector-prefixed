<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use function PHPStan\Analyser\assertType;
function bug1014() : void
{
    $s = \rand(0, 1) ? 0 : 1;
    \PHPStan\Analyser\assertType('0|1', $s);
    if ($s) {
        \PHPStan\Analyser\assertType('1', $s);
        $s = 3;
        \PHPStan\Analyser\assertType('3', $s);
    } else {
        \PHPStan\Analyser\assertType('0', $s);
    }
    \PHPStan\Analyser\assertType('0|3', $s);
    if ($s === 1) {
    }
}
