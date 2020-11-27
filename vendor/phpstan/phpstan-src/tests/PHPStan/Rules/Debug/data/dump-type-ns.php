<?php

namespace _PhpScoper88fe6e0ad041\App\Foo;

function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    dumpType($a);
};
