<?php

namespace _PhpScopera143bcca66cb\App\Foo;

use function PHPStan\dumpType;
function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    \PHPStan\dumpType($a);
};
