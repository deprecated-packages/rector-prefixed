<?php

namespace _PhpScoper88fe6e0ad041\Bug3875;

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
