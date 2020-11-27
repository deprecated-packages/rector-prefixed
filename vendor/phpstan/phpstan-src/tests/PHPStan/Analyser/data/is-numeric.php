<?php

namespace _PhpScoper006a73f0e455;

function () {
    /** @var int|string $s */
    $s = \_PhpScoper006a73f0e455\doFoo();
    if (!\is_numeric($s)) {
        \PHPStan\Analyser\assertType('string', $s);
    }
};
