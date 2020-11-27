<?php

namespace _PhpScoper006a73f0e455;

use function PHPStan\Analyser\assertType;
const TABLE_NAME = 'resized_images';
\define('ANOTHER_NAME', 'foo');
\PHPStan\Analyser\assertType('\'resized_images\'', \TABLE_NAME);
\PHPStan\Analyser\assertType('\'resized_images\'', \TABLE_NAME);
\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
function () {
    \PHPStan\Analyser\assertType('\'resized_images\'', \TABLE_NAME);
    \PHPStan\Analyser\assertType('\'resized_images\'', \TABLE_NAME);
    \PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
    \PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
};
