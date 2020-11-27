<?php

namespace _PhpScoper88fe6e0ad041;

use function PHPStan\Analyser\assertType;
$image = \imagecreatetruecolor(1, 1);
$memoryHandle = \fopen('php://memory', 'w');
\PHPStan\Analyser\assertType('bool', \imagegd($image));
\PHPStan\Analyser\assertType('bool', \imagegd($image, null));
\PHPStan\Analyser\assertType('bool', \imagegd($image, 'php://memory'));
\PHPStan\Analyser\assertType('bool', \imagegd($image, $memoryHandle));