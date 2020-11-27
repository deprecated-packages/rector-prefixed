<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

function () {
    echo [];
    echo new \stdClass();
    echo [], new \stdClass();
    echo function () {
    };
    echo 13132, 'string';
    echo \random_int(0, 1) ? ['string'] : 'string';
};
function (array $test) {
    /** @var string $test */
    echo $test;
};
