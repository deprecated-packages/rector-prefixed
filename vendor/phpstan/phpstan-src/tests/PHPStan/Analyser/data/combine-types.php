<?php

namespace _PhpScoper88fe6e0ad041;

$x = null;
/** @var string[] $arr */
$arr = \_PhpScoper88fe6e0ad041\doFoo();
foreach ($arr as $foo) {
    $x = $foo;
}
$y = null;
if (\_PhpScoper88fe6e0ad041\doFoo()) {
} else {
    if (\_PhpScoper88fe6e0ad041\doBar()) {
    } else {
        $y = 1;
    }
}
die;
