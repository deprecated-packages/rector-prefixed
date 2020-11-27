<?php

namespace _PhpScoper26e51eeacccf\InvalidIncDec;

function ($a, int $i, ?float $j, string $str, \stdClass $std) {
    $a++;
    $b = [1];
    $b[0]++;
    \date('j. n. Y')++;
    \date('j. n. Y')--;
    $i++;
    $j++;
    $str++;
    $std++;
};
