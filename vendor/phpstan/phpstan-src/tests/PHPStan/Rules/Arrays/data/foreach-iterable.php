<?php

namespace _PhpScoperbd5d0c5f7638\IterablesInForeach;

foreach ([1, 2, 3] as $x) {
}
$string = 'foo';
foreach ($string as $x) {
}
$arrayOrFalse = [1, 2, 3];
if (doFoo()) {
    $arrayOrFalse = \false;
}
foreach ($arrayOrFalse as $val) {
}
$arrayOrNull = [];
if (doFoo()) {
    $arrayOrNull = null;
}
if (empty($arrayOrNull)) {
} elseif (empty($arrayOrFalse)) {
} else {
    foreach ($arrayOrNull as $val) {
    }
    foreach ($arrayOrFalse as $vla) {
    }
}
/** @var mixed $mixed */
$mixed = doFoo();
foreach ($mixed as $val) {
}
foreach (new \_PhpScoperbd5d0c5f7638\IterablesInForeach\Bar() as $val) {
}
