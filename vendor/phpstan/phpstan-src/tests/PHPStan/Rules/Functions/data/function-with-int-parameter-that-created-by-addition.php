<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

foreach ([1, 2, 3] as $i) {
    if (!isset($sum)) {
        $sum = 0;
    }
    $sum = $sum + $i;
    \dechex($sum);
}
/** @var float|int $doFooResult */
$doFooResult = \_PhpScoperabd03f0baf05\doFoo();
if (!isset($floatOrInt)) {
    $floatOrInt = $doFooResult;
}
$floatOrInt += $i;
\dechex($floatOrInt);
function () {
    foreach ([1, 2, 3] as $i) {
        if (!isset($sum)) {
            $sum = 0;
        }
        $sum = $sum + $i;
        \dechex($sum);
    }
    /** @var float|int $doFooResult */
    $doFooResult = \_PhpScoperabd03f0baf05\doFoo();
    if (!isset($floatOrInt)) {
        $floatOrInt = $doFooResult;
    }
    $floatOrInt += $i;
    \dechex($floatOrInt);
};
