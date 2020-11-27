<?php

namespace _PhpScoperbd5d0c5f7638;

$x = null;
/** @var string[] $arr */
$arr = \_PhpScoperbd5d0c5f7638\doFoo();
foreach ($arr as $foo) {
    $x = $foo;
}
$y = null;
if (\_PhpScoperbd5d0c5f7638\doFoo()) {
} else {
    if (\_PhpScoperbd5d0c5f7638\doBar()) {
    } else {
        $y = 1;
    }
}
die;
