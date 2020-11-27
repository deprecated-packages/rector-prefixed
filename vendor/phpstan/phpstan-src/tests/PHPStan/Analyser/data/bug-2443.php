<?php

namespace _PhpScoper006a73f0e455\Analyser\Bug2443;

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
