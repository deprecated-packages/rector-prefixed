<?php

namespace _PhpScoper88fe6e0ad041\App\Foo;

use function PHPStan\dumpType;
function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    \PHPStan\dumpType($a);
};
