<?php

namespace _PhpScoper26e51eeacccf\Bug3997Type;

use function PHPStan\Analyser\assertType;
function (\Countable $c) : void {
    \PHPStan\Analyser\assertType('int<0, max>', $c->count());
    \PHPStan\Analyser\assertType('int<0, max>', \count($c));
};
function (\ArrayIterator $i) : void {
    \PHPStan\Analyser\assertType('int<0, max>', $i->count());
    \PHPStan\Analyser\assertType('int<0, max>', \count($i));
};
