<?php

namespace _PhpScoperbd5d0c5f7638\App\Foo;

use function PHPStan\dumpType;
function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    \PHPStan\dumpType($a);
};
