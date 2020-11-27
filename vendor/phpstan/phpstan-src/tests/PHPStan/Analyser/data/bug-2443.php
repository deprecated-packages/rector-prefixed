<?php

namespace _PhpScoper26e51eeacccf\Analyser\Bug2443;

use function PHPStan\Analyser\assertType;
/**
 * @param array<int,mixed> $a
 */
function (array $a) : void {
    \PHPStan\Analyser\assertType('bool', \array_filter($a) !== []);
    \PHPStan\Analyser\assertType('bool', [] !== \array_filter($a));
    \PHPStan\Analyser\assertType('bool', \array_filter($a) === []);
    \PHPStan\Analyser\assertType('bool', [] === \array_filter($a));
};
