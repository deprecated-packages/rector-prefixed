<?php

namespace _PhpScoperbd5d0c5f7638\ConstInFunctions;

use function PHPStan\Analyser\assertType;
use const _PhpScoperbd5d0c5f7638\CONDITIONAL;
const TABLE_NAME = 'resized_images';
\define('ANOTHER_NAME', 'foo');
\define('_PhpScoperbd5d0c5f7638\\ConstInFunctions\\ANOTHER_NAME', 'bar');
\PHPStan\Analyser\assertType('\'resized_images\'', TABLE_NAME);
\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
\PHPStan\Analyser\assertType('\'bar\'', ANOTHER_NAME);
\PHPStan\Analyser\assertType('\'resized_images\'', \_PhpScoperbd5d0c5f7638\ConstInFunctions\TABLE_NAME);
\PHPStan\Analyser\assertType('\'bar\'', \_PhpScoperbd5d0c5f7638\ConstInFunctions\ANOTHER_NAME);
if (\rand(0, 1)) {
    \define('CONDITIONAL', \true);
} else {
    \define('CONDITIONAL', \false);
}
\PHPStan\Analyser\assertType('bool', \CONDITIONAL);
\PHPStan\Analyser\assertType('bool', \CONDITIONAL);
function () {
    \PHPStan\Analyser\assertType('\'resized_images\'', TABLE_NAME);
    \PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
    \PHPStan\Analyser\assertType('\'bar\'', ANOTHER_NAME);
    \PHPStan\Analyser\assertType('\'resized_images\'', \_PhpScoperbd5d0c5f7638\ConstInFunctions\TABLE_NAME);
    \PHPStan\Analyser\assertType('\'bar\'', \_PhpScoperbd5d0c5f7638\ConstInFunctions\ANOTHER_NAME);
    if (\CONDITIONAL) {
        \PHPStan\Analyser\assertType('true', \CONDITIONAL);
        \PHPStan\Analyser\assertType('true', \CONDITIONAL);
    } else {
        \PHPStan\Analyser\assertType('false', \CONDITIONAL);
        \PHPStan\Analyser\assertType('false', \CONDITIONAL);
    }
    \PHPStan\Analyser\assertType('bool', \CONDITIONAL);
    \PHPStan\Analyser\assertType('bool', \CONDITIONAL);
};
