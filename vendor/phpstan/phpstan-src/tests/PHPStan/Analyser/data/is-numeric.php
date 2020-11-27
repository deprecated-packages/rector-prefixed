<?php

namespace _PhpScopera143bcca66cb;

function () {
    /** @var int|string $s */
    $s = \_PhpScopera143bcca66cb\doFoo();
    if (!\is_numeric($s)) {
        \PHPStan\Analyser\assertType('string', $s);
    }
};
