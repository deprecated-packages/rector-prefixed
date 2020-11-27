<?php

namespace _PhpScoper006a73f0e455\DeadForeach;

function (array $a) {
    foreach ($a as $val) {
    }
};
function (array $a) {
    if (\count($a) === 0) {
        foreach ($a as $val) {
        }
    }
};
function () {
    foreach ([1, 2, 3] as $val) {
    }
};
function () {
    foreach ([] as $val) {
    }
};
