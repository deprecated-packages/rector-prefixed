<?php

namespace _PhpScoper26e51eeacccf;

use function PHPStan\Analyser\assertType;
\PHPStan\Analyser\assertType('array<int, string>|false', \preg_split('/-/', '1-2-3'));
\PHPStan\Analyser\assertType('array<int, string>|false', \preg_split('/-/', '1-2-3', -1, \PREG_SPLIT_NO_EMPTY));
\PHPStan\Analyser\assertType('array<int, array(string, int)>|false', \preg_split('/-/', '1-2-3', -1, \PREG_SPLIT_OFFSET_CAPTURE));
\PHPStan\Analyser\assertType('array<int, array(string, int)>|false', \preg_split('/-/', '1-2-3', -1, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_OFFSET_CAPTURE));
