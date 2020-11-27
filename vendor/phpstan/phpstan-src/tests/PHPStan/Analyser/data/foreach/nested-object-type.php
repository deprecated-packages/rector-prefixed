<?php

namespace _PhpScoper006a73f0e455;

use _PhpScoper006a73f0e455\AnotherNamespace\Foo;
/** @var Foo[][] $fooses */
$fooses = \_PhpScoper006a73f0e455\foos();
foreach ($fooses as $foos) {
    foreach ($foos as $foo) {
        die;
    }
}
