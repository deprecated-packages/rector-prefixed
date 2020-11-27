<?php

namespace _PhpScoper26e51eeacccf\App\Foo;

function (array $a) {
    if ($a === []) {
        return;
    }
    \PHPStan\dumpType($a);
    dumpType($a);
};
