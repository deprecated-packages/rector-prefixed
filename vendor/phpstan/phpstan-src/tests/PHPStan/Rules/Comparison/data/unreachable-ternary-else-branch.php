<?php

namespace _PhpScoperabd03f0baf05;

function (\stdClass $std, string $str) {
    $str ? 'foo' : 'bar';
    $std instanceof \stdClass ? 'foo' : 'bar';
    // unreachable
    $str ?: 'bar';
    $std instanceof \stdClass ?: 'bar';
    // unreachable
};
