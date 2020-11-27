<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Implode74;

function (string $a, string $b, array $array) : void {
    \implode($a, $array);
    \implode($array);
    \implode($array, $a);
    // disallowed
};
