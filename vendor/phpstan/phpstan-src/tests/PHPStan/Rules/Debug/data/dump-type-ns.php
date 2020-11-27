<?php

namespace _PhpScopera143bcca66cb\App\Foo;

function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    dumpType($a);
};
