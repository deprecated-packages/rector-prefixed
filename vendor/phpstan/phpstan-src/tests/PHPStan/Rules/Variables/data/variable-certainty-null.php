<?php

namespace _PhpScoper26e51eeacccf;

function () : void {
    $scalar = 3;
    echo $scalar ?? 4;
    echo $doesNotExist ?? 0;
};
function (?string $a) : void {
    if (!\is_string($a)) {
        echo $a ?? 'foo';
    }
};
