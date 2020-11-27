<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Implode74;

function (string $a, string $b, array $array) : void {
    \implode($a, $array);
    \implode($array);
    \implode($array, $a);
    // disallowed
};
