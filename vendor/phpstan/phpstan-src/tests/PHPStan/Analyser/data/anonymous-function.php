<?php

namespace _PhpScoperbd5d0c5f7638\AnonymousFunction;

function () {
    $integer = 1;
    function (string $str, ...$arr) use($integer, $bar) {
        die;
    };
};
