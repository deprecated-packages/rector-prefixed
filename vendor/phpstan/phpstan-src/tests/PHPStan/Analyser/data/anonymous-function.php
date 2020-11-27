<?php

namespace _PhpScoper26e51eeacccf\AnonymousFunction;

function () {
    $integer = 1;
    function (string $str, ...$arr) use($integer, $bar) {
        die;
    };
};
