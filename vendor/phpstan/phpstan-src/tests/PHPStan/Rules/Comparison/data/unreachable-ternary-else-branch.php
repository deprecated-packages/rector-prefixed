<?php

namespace _PhpScoper88fe6e0ad041;

function (\stdClass $std, string $str) {
    $str ? 'foo' : 'bar';
    $std instanceof \stdClass ? 'foo' : 'bar';
    // unreachable
    $str ?: 'bar';
    $std instanceof \stdClass ?: 'bar';
    // unreachable
};
