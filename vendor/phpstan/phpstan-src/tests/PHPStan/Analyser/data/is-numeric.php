<?php

namespace _PhpScoper26e51eeacccf;

function () {
    /** @var int|string $s */
    $s = \_PhpScoper26e51eeacccf\doFoo();
    if (!\is_numeric($s)) {
        \PHPStan\Analyser\assertType('string', $s);
    }
};
