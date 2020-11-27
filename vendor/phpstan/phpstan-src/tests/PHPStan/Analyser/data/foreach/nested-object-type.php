<?php

namespace _PhpScoper88fe6e0ad041;

use _PhpScoper88fe6e0ad041\AnotherNamespace\Foo;
/** @var Foo[][] $fooses */
$fooses = \_PhpScoper88fe6e0ad041\foos();
foreach ($fooses as $foos) {
    foreach ($foos as $foo) {
        die;
    }
}
