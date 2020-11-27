<?php

namespace _PhpScoper26e51eeacccf\Bug3875;

use function PHPStan\Analyser\assertType;
function foo() : void
{
    $queue = ['foo'];
    $list = [];
    do {
        $current = \array_pop($queue);
        \PHPStan\Analyser\assertType('\'foo\'', $current);
        if ($current === null) {
            break;
        }
        $list[] = $current;
    } while ($queue);
}
