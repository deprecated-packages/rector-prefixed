<?php

namespace _PhpScopera143bcca66cb;

$x = null;
/** @var string[] $arr */
$arr = \_PhpScopera143bcca66cb\doFoo();
foreach ($arr as $foo) {
    $x = $foo;
}
$y = null;
if (\_PhpScopera143bcca66cb\doFoo()) {
} else {
    if (\_PhpScopera143bcca66cb\doBar()) {
    } else {
        $y = 1;
    }
}
die;
