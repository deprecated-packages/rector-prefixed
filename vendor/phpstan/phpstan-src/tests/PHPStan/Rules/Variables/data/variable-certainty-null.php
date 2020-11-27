<?php

namespace _PhpScoper88fe6e0ad041;

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
