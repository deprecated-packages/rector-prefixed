<?php

namespace _PhpScoper006a73f0e455;

$x = null;
/** @var string[] $arr */
$arr = \_PhpScoper006a73f0e455\doFoo();
foreach ($arr as $foo) {
    $x = $foo;
}
$y = null;
if (\_PhpScoper006a73f0e455\doFoo()) {
} else {
    if (\_PhpScoper006a73f0e455\doBar()) {
    } else {
        $y = 1;
    }
}
die;
