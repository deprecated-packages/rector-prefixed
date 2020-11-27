<?php

namespace _PhpScopera143bcca66cb;

use _PhpScopera143bcca66cb\AnotherNamespace\Foo;
/** @var Foo[][] $fooses */
$fooses = \_PhpScopera143bcca66cb\foos();
foreach ($fooses as $foos) {
    foreach ($foos as $foo) {
        die;
    }
}
