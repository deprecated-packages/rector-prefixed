<?php

namespace _PhpScoperabd03f0baf05\Analyser\Bug2750;

use function PHPStan\Analyser\assertType;
function (array $input) {
    \assert(\count($input) > 0);
    \PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \array_shift($input);
    \PHPStan\Analyser\assertType('int<0, max>', \count($input));
    \assert(\count($input) > 0);
    \PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \array_pop($input);
    \PHPStan\Analyser\assertType('int<0, max>', \count($input));
    \assert(\count($input) > 0);
    \PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \array_unshift($input, 'test');
    \PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \assert(\count($input) > 0);
    \PHPStan\Analyser\assertType('int<1, max>', \count($input));
    \array_push($input, 'nope');
    \PHPStan\Analyser\assertType('int<1, max>', \count($input));
};
