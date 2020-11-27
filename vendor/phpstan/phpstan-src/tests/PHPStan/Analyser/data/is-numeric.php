<?php

namespace _PhpScoperbd5d0c5f7638;

function () {
    /** @var int|string $s */
    $s = \_PhpScoperbd5d0c5f7638\doFoo();
    if (!\is_numeric($s)) {
        \PHPStan\Analyser\assertType('string', $s);
    }
};
