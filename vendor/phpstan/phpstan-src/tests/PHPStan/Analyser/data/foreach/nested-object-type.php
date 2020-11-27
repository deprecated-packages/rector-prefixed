<?php

namespace _PhpScoper26e51eeacccf;

use _PhpScoper26e51eeacccf\AnotherNamespace\Foo;
/** @var Foo[][] $fooses */
$fooses = \_PhpScoper26e51eeacccf\foos();
foreach ($fooses as $foos) {
    foreach ($foos as $foo) {
        die;
    }
}
