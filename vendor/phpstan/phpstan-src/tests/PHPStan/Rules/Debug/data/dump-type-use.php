<?php

namespace _PhpScoper26e51eeacccf\App\Foo;

use function PHPStan\dumpType;
function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    \PHPStan\dumpType($a);
};
