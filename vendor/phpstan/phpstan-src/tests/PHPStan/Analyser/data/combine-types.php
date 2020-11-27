<?php

namespace _PhpScoper26e51eeacccf;

$x = null;
/** @var string[] $arr */
$arr = \_PhpScoper26e51eeacccf\doFoo();
foreach ($arr as $foo) {
    $x = $foo;
}
$y = null;
if (\_PhpScoper26e51eeacccf\doFoo()) {
} else {
    if (\_PhpScoper26e51eeacccf\doBar()) {
    } else {
        $y = 1;
    }
}
die;
