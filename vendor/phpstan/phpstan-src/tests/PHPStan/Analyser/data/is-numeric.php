<?php

namespace _PhpScoperabd03f0baf05;

function () {
    /** @var int|string $s */
    $s = \_PhpScoperabd03f0baf05\doFoo();
    if (!\is_numeric($s)) {
        \PHPStan\Analyser\assertType('string', $s);
    }
};
