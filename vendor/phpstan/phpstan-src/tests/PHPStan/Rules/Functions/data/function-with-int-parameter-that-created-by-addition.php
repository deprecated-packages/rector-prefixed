<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

foreach ([1, 2, 3] as $i) {
    if (!isset($sum)) {
        $sum = 0;
    }
    $sum = $sum + $i;
    \dechex($sum);
}
/** @var float|int $doFooResult */
$doFooResult = \_PhpScopera143bcca66cb\doFoo();
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
    $doFooResult = \_PhpScopera143bcca66cb\doFoo();
    if (!isset($floatOrInt)) {
        $floatOrInt = $doFooResult;
    }
    $floatOrInt += $i;
    \dechex($floatOrInt);
};
