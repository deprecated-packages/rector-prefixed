<?php

namespace _PhpScopera143bcca66cb\Analyser\Bug2443;

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
