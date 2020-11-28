<?php

namespace _PhpScoperabd03f0baf05\App\Foo;

function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    dumpType($a);
};
