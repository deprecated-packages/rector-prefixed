<?php

namespace _PhpScoper88fe6e0ad041;

function () {
    /** @var int|string $s */
    $s = \_PhpScoper88fe6e0ad041\doFoo();
    if (!\is_numeric($s)) {
        \PHPStan\Analyser\assertType('string', $s);
    }
};
