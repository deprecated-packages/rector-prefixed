<?php

namespace _PhpScoperbd5d0c5f7638\App\Foo;

function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    dumpType($a);
};
