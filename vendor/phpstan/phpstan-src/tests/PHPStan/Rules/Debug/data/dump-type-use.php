<?php

namespace _PhpScoper006a73f0e455\App\Foo;

use function PHPStan\dumpType;
function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    \PHPStan\dumpType($a);
};
